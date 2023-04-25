<?php
/*
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version April 2023
 */
class page_counter {
#
#   Basisfunktionen
#      counter_mod_id()
#      counter_get($art_id,$clang_id)
#      get_counter()
#      set_counter()
#      counter_collect($min,$clang_id)
#      counter_out($min,$clang_id)
#   Modul und Beispiel
#      modul_inp($min,$clang_id)
#      modul_outp($min,$clang_id)
#      counter_page()
#   Installation
#      insert_counter_column()
#      define_module($mypackage)
#      build_module($mypackage)
#
# -------------------- Konstanten
const COUNTER='art_counter';    // Name der rex_article-Spalte
#
# -------------------- Basisfunktionen
public static function counter_mod_id() {
   #   Rueckgabe der Modul-Id des Aufrufzaehler-Moduls
   #
   $search='%page_counter::modul_outp%';
   $sql=rex_sql::factory();
   $query='SELECT * FROM rex_module WHERE output LIKE "'.$search.'"';
   $mods=$sql->getArray($query);
   if(empty($mods)):
     return 0;
     else:
     return $mods[0]['id'];
     endif;
   }
public static function counter_get($art_id,$clang_id) {
   #   Rueckgabe der Anzahl Aufrufe auf eine Seite. Die Anzahl der
   #   Aufrufe einer Seite ist gespeichert in der zusaetzlichen Spalte
   #   'art_counter' der Tabelle 'rex_article'.
   #   Falls die Seite den Aufrufzaehler-Modul enthaelt, wird ab dem
   #   Datum gezaehlt, an dem der Modul angelegt wurde.
   #   Alternativ wird ab dem Datum gezaehlt, an dem der Artikel angelegt
   #   wurde (dann muss der Zaehler im Seitentemplate eingerichtet sein).
   #   Rueckgabe eines assoziativen Arrays dieser Form:
   #          ['count']    Anzahl der Aufrufe
   #          ['since']    Datum der Einrichtung der Seite/des Zaehler-Moduls
   #          ['days']     Anzahl Tage seit Einrichtung der Seite/des Zaehler-Moduls
   #          ['daycount'] Anzahl der Aufrufe pro Tag
   #   $art_id             Id der betreffenden Seite
   #   $clang_id           Sprach-Id der betreffenden Seite
   #   benutzte functions:
   #      self::counter_mod_id()
   #
   $mod_id=self::counter_mod_id();   // Id des Aufrufzaehler-Moduls
   if($mod_id<=0) return array();
   $sql=rex_sql::factory();
   #
   # --- Artikel heraussuchen
   $where ='id='.$art_id.' AND clang_id='.$clang_id;
   $query='SELECT * FROM rex_article WHERE '.$where;
   $result=$sql->getArray($query);
   $article=$result[0];
   #
   # --- Aufrufzaehlung seit (ALLE Artikelaufrufe per Seitentemplate gezaehlt)
   $date=$article['createdate'];     // Format (Redaxo 5): 2017-12-08 19:31:46
   $date=strtotime($date);           // Wandlung in UNIX-Timestamp
   #
   # --- Aufrufzaehlung seit (nur Aufrufe von Artikeln mit Zaehlermodul gezaehlt)
   $where='article_id='.$art_id.' AND clang_id='.$clang_id.' AND module_id='.$mod_id;
   $query='SELECT * FROM rex_article_slice WHERE '.$where;
   $result=$sql->getArray($query);
   if(!empty($result[0])):
     $date=$result[0]['createdate']; // Format (Redaxo 5): 2017-12-08 19:31:46
     $date=strtotime($date);         // Wandlung in UNIX-Timestamp
     endif;
   #
   # --- Tagesdifferenz bis heute
   $heute=time();
   $diff=($heute-$date)/(24*60*60);
   $days=intval($diff);
   if($diff-$days>0.5) $days=$days+1;
   #
   # --- mittlere Aufrufe/Tag (ggf. aufrunden)
   $tr=intval($article[self::COUNTER]);
   if(intval($days)>0) $tr=$tr/$days;
   $arr=explode(',',$tr);
   $ts=0;
   if(!empty($arr[1])) $ts=intval(substr($arr[1],0,1));
   $daycount=intval($arr[0]);
   if($ts>=5) $daycount=$daycount+1;
   if($daycount<1) $daycount=1;      // unter 0.5 auf 1 aufrunden
   #
   # --- Rueckgabe-Parameter
   $count['count']   =intval($article[self::COUNTER]);
   $count['since']   =date('j.n.Y',$date);
   $count['days']    =$days;
   $count['daycount']=$daycount;
   return $count;
   }
public static function get_counter() {
   #   Rueckgabe der Anzahl Aufrufe auf die aktuelle Seite.
   #   benutzte functions:
   #      self::counter_get($art_id,$clang_id)
   #
   $art_id=rex_article::getCurrentId();
   $clang_id=rex_clang::getCurrentId();
   return self::counter_get($art_id,$clang_id);
   }
public static function set_counter() {
   #   Erhoehung der Anzahl Aufrufe auf eine Seite
   #   (wird nur im Frontend durchgefuehrt).
   #   Die Anzahl der Aufrufe einer Seite ist gespeichert in der
   #   Spalte self::COUNTER der Tabelle 'rex_article'.
   #   benutze functions:
   #      self::get_counter();
   #
   if(rex::isBackend()) return;
  #
   # --- Zaehler auslesen
   $count=self::get_counter();
   $anz=$count['count'];
   #
   # --- Zaehler um 1 erhoehen und zurueckschreiben
   $anz=$anz+1;
   $art_id=rex_article::getCurrentId();
   $clang_id=rex_clang::getCurrentId();
   $sql=rex_sql::factory();
   $table='rex_article';
   $where ='id='.$art_id.' AND clang_id='.$clang_id;
   $update='UPDATE '.$table.' SET '.self::COUNTER.'='.$anz.' WHERE '.$where;
   $sql->setQuery($update);
   }
public static function counter_collect($min,$clang_id) {
   #   Rueckgabe aller Artikel einer Sprache (oder aller Sprachen), deren
   #   Aufrufanzahl einen Schwellwert ueberschreitet, in absteigender Reihenfolge
   #   der Aufrufanzahlen. Die Artikel werden zurueck gegeben als nummeriertes
   #   Array (Nummerierung beginnend bei 1) in dieser Form:
   #      $anz[$i]['id']       = Id des Artikels
   #              ['clang_id'] = Sprach-Id des Artikels
   #              ['count']    = Anzahl der Aufrufe
   #              ['since']    = Datum des Beginns der Zaehlung
   #              ['days']     = Anzahl Tage seit Einrichtung der Seite/des Zaehler-Moduls
   #              ['daycount'] = Anzahl der Aufrufe pro Tag
   #   Das Array ist nach der Aufrufanzahl (absteigend) sortiert.
   #   $min                Mindestanzahl der bisher erfolgten Aufrufe (Artikel
   #                       mit weniger Aufrufen werden nicht erfasst)
   #   $clang_id           >0:  nur Artikel dieser Sprache
   #                       <=0: Artikel aller Sprachen
   #   benutzte functions:
   #      self::counter_get($art_id,$clang_id)
   #
   # --- alle Artikel ermitteln, die mindestens $min mal aufgerufen wurden
   $minz=max(1,$min-1);
   $sql=rex_sql::factory();
   $where='art_counter>'.$minz;
   if($clang_id>0) $where=$where.' AND clang_id='.$clang_id;
   $query='SELECT * FROM rex_article WHERE '.$where.' ORDER BY art_counter DESC';
   $articles=$sql->getArray($query);
   $arts=array();
   for($i=0;$i<count($articles);$i=$i+1):
      $k=$i+1;
      $aid=$articles[$i]['id'];
      $cid=$articles[$i]['clang_id'];
      $anz=self::counter_get($aid,$cid);
      $arts[$k]=array('id'=>$aid, 'clang_id'=>$cid, 'count'=>$anz['count'],
         'since'=>$anz['since'], 'days'=>$anz['days'], 'daycount'=>$anz['daycount']);
   endfor;
   return $arts;
   }
public static function counter_out($min,$clang_id) {
   #   Rueckgabe des HTML-Codes zur Darstellung der Aufrufstatistik der Seiten mit
   #   einer Mindestanzahl von Aufrufen, ggf. nur die Artikel einer Sprache.
   #   $min                Mindestanzahl der bisher erfolgten Aufrufe
   #                       (Artikel mit weniger Aufrufen werden nicht erfasst)
   #   $clang_id           >0:  nur Artikel dieser Sprache
   #                       <=0: Artikel aller Sprachen
   #   benutzte functions:
   #      self::counter_collect($min,$clang_id)
   #
   # --- Sprache
   $ueber2=' [alle Sprachen]';
   if($clang_id>0)
     $ueber2=' ['.rex_clang::get($clang_id)->getName().']';
   if(rex_clang::count()<=1) $ueber2='';
   if($min>=2) $ueber2=$ueber2.'<br>
            <small>(nur Seiten mit mindestens '.$min.' Aufrufen)</small>';
   #
   # --- Ausgaben
   $arts=self::counter_collect($min,$clang_id);
   $str='<table class="counter_table">
    <tr><td colspan="6">
            <h3 align="center">Hitliste der Seitenaufrufe'.$ueber2.'</h3></td></tr>
    <tr valign="bottom">
        <td class="counter_nowrap">
            <b><u>Nr.</u></b></td>
        <td class="counter_indent">
            <b><u>Seite</u></b></td>
        <td class="counter_right" >
            <b>Anzahl<br><u>insgesamt</u></b>&nbsp;</td>
        <td class="counter_right" >
            <b>Aufrufe<br>&nbsp;<u>pro Tag</u></b></td>
        <td class="counter_right" >
            <b><u>seit</u></b></td>
        <td> </td></tr>';
   for($i=1;$i<=count($arts);$i=$i+1):
      $art_id  =$arts[$i]['id'];
      $clang_id=$arts[$i]['clang_id'];
      $count   =$arts[$i]['count'];
      $since   =$arts[$i]['since'];
      $days    =$arts[$i]['days'];
      $daycount=$arts[$i]['daycount'];
      $count   =number_format($count,   0,',','.');
      $daycount=number_format($daycount,0,',','.');
      $days    =number_format($days,    0,',','.');
      $clang='';
      if($clang_id>1) $clang=' ('.rex_clang::get($clang_id)->getCode().')';
      if($clang_id==rex_clang::getCurrentId()):
        $url=rex_getUrl($art_id,$clang_id);
        $ref='<a href="'.$url.'" target="_blank">'.$url.'</a>';
        else:
        $ref=rex_getUrl($art_id,rex_clang::getCurrentId());
        endif;
      $string=$ref.$clang;
      $str=$str.'
    <tr><td class="counter_right">
            '.$i.')</td>
        <td class="counter_indent counter_nowrap">
            '.$string.':</td>
        <td class="counter_right counter_red">
            '.$count.'</td>
        <td class="counter_right" >
            &sim; <span class="counter_red">'.$daycount.'</span></td>
        <td class="counter_right" >
            <tt> &nbsp; '.$since.'</tt></td>
        <td class="counter_right">
            &nbsp; <small>('.$days.' Tage)</small></td></tr>';
      endfor;
   $str=$str.'
</table>
';
   return $str;
   }
#
# -------------------- Modul und Beispiel
public static function modul_inp($min,$clang_id) {
   #   Rueckgabe des PHP-Codes fuer den Input-Teil des Moduls.
   #   $min                = REX_VALUE[1]: minimale Aufrufzahl,
   #                       ab der ein Artikel in der Aufrufstatistik erscheint
   #   $clang_id           = REX_VALUE[2]: Sprach-Id der auszugebenden Artikel
   #                       >0:  nur Artikel dieser Sprache
   #                       <=0: Artikel aller Sprachen
   #
   $str='
<h4 align="center">Alternative Nutzung des Moduls</h4>

<div><u>a) Aktivierung der Aufrufzählung für diesen Artikel:</u></div>
<div class="counter_indent">
    Dazu muss das <b>Eingabefeld</b> &quot;Mindestanzahl&quot; (siehe unten) <b>leer</b> bleiben!</div>

<div><br><u>b) Ausgabe einer Aufrufstatistik in Form einer Hitliste:</u></div>
<div class="counter_indent">
    Dazu muss das folgende Eingabefeld mit einer positiven Zahl ausgefüllt werden.
    Die Zahl gibt die <b>Mindestanzahl von Aufrufen</b> an, ab der ein Artikel in
    der Hitliste aufgeführt wird (Parameter zur Verkürzung der Liste).
    <div class="counter_indent">
        <input type="number" min="0" class="counter_right counter_inpwid"
               name="REX_INPUT_VALUE[1]" value="'.$min.'"> &nbsp;
        (Mindestanzahl von Aufrufen)</div></div>
';
   $anz=rex_clang::count();
   if($anz>1):
     $str=$str.'<div class="counter_indent">
    <div>Hitliste <b>getrennt nach Sprachen</b> oder <b>über alle Sprachen</b>?</div>';
     $cl=array();
     $cl[0]['id']  =0;
     $cl[0]['lang']='alle Sprachen';
     for($i=1;$i<=$anz;$i=$i+1):
        $cl[$i]['id']  =$i;
        $cl[$i]['lang']=rex_clang::get($i)->getName();
        endfor;
     $str=$str.'
    <div class="counter_indent">
        <select name="REX_INPUT_VALUE[2]">';
     for($i=0;$i<count($cl);$i=$i+1)
        if($cl[$i]['id']==$clang_id):
          $str=$str.'
            <option value="'.$i.'" selected>'.$cl[$i]['lang'].'</option>';
          else:
          $str=$str.'
            <option value="'.$i.'">'.$cl[$i]['lang'].'</option>';
          endif;          
     $str=$str.'
        </select></div></div>
';
     endif;
   return $str;
   }
public static function modul_outp($min,$clang_id) {
   #   Rueckgabe des PHP-Codes fuer den Output-Teil des Moduls.
   #   $min                = REX_VALUE[1]: minimale Aufrufzahl,
   #                       ab der ein Artikel in der Aufrufstatistik erscheint
   #   $clang_id           = REX_VALUE[2]: Sprach-Id der auszugebenden Artikel
   #                       >0:  nur Artikel dieser Sprache
   #                       <=0: Artikel aller Sprachen
   #   benutzte functions:
   #      self::counter_out($min,$clang_id)
   #      self::set_counter()
   #      self::get_counter()
   #
   if($min>0):
     #
     # --- Aufrufstatistik
     if(!rex::isBackend()):
       $str=self::counter_out($min,$clang_id);
       else:
       $lang='alle Sprachen';
       if($clang_id>0) $lang=rex_clang::get($clang_id)->getName();
       $str='<div><b>Hitliste der Seitenaufrufe</b> ('.$lang.')' ;
       if($min>=2) $str=$str.', nur Seiten mit mindestens '.$min.' Aufrufen';
       $str=$str.'
<br>(nur im Frontend angezeigt)</div>';
       endif;
     else:
     #
     # --- Aktivierung der Aufrufzaehlung
     if(!rex::isBackend()):
       self::set_counter();
       $str='';
       else:
       #     Kurzfassung der Aufrufe des aktuellen Artikels
       $anz=self::get_counter();
       if(count($anz)>0):
         $counts=number_format($anz['count'],   0,',','.');
         $counts='<span class="counter_red">'.$counts.'</span>';
         $since =$anz['since'];
         $days  =number_format($anz['days'],    0,',','.');
         $perday=number_format($anz['daycount'],0,',','.');
         $str='<div><b>'.$counts.'</b> &nbsp; Aufrufe &nbsp; seit '.$since.' &nbsp; '.
            '('.$days.' Tage, &nbsp; ca. '.$perday.' Aufrufe pro Tag)</b></div>';
         else:
         $str='+++++ page_counter-Modul nicht gefunden';
         endif;
       endif;
     endif;
   return $str;
   }
public static function counter_page() {
   #
   # --- gesendete Daten auslesen
   $min=1;
   if(isset($_POST['minimum'])) $min=$_POST['minimum'];
   $clang_id=0;
   if(isset($_POST['sprache'])) $clang_id=$_POST['sprache'];
   #
   # --- Mindestanzahl von Aufrufen
   $str='
<h4 align="center">Ausgabe einer Aufrufstatistik in Form einer Hitliste</h4>

<form method="post">
<div><br><b>Mindestanzahl von Aufrufen</b> (Artikel mit weniger Aufrufen werden nicht mit angezeigt):</div>
<div class="counter_indent">
    <input type="number" min="1" class="counter_right counter_inpwid"
           name="minimum" value="'.$min.'"></div>
';
   #
   # --- Sprache
   $anz=rex_clang::count();
   if($anz>1):
     $str=$str.'<div><br>Hitliste <b>getrennt nach Sprachen</b> oder <b>über alle Sprachen</b>?</div>';
     $cl=array();
     $cl[0]['id']  =0;
     $cl[0]['lang']='alle Sprachen';
     for($i=1;$i<=$anz;$i=$i+1):
        $cl[$i]['id']  =$i;
        $cl[$i]['lang']=rex_clang::get($i)->getName();
        endfor;
     $str=$str.'
    <div class="counter_indent">
        <select name="sprache">';
     for($i=0;$i<count($cl);$i=$i+1)
        if($cl[$i]['id']==$clang_id):
          $str=$str.'
            <option value="'.$i.'" selected>'.$cl[$i]['lang'].'</option>';
          else:
          $str=$str.'
            <option value="'.$i.'">'.$cl[$i]['lang'].'</option>';
          endif;          
     $str=$str.'
        </select></div>
';
     endif;
   #
   # --- Button
   $str=$str.'<div><br>
<button class="btn btn-view">anzeigen</button>
</form><br>
&nbsp;</div>
';
   #
   # --- Ausgabe
   $str=$str.'<div align="center" class="counter_indent">
    <div class="counter_box">'.
        self::counter_out($min,$clang_id).'<br>
    &nbsp;</div></div>';
   echo $str;
   }
#
# -------------------- Installation
public static function insert_counter_column() {
   #   Einfuegen der Aufrufzaehler-Spalte in rex_article, falls diese
   #   noch nicht vorhanden ist.
   #
   $table='rex_article';
   $cols=rex_sql::showColumns($table,$DBID=1);
   $vorh=FALSE;
   for($i=0;$i<count($cols);$i=$i+1)
      if($cols[$i]['name']==self::COUNTER) $vorh=TRUE;
   if(!$vorh):
     $sql=rex_sql::factory();
     $alter='ALTER TABLE '.$table.' ADD '.self::COUNTER.' INT';
     $sql->setQuery($alter);
     endif;
   }
public static function define_module($mypackage) {
   #   Rueckgabe der Quelle des Aufrufzaehler-Moduls in Form eines
   #   assoziativen Arrays:
   #      $mod['name']     Titel/Name des Moduls
   #      $mod['input']    Input-Teil des Moduls
   #      $mod['output']   Output-Teil des Moduls
   #   $mypackage          Name des AddOns
   #
   $name='Aufrufzähler ('.$mypackage.')';
   $in='<?php
$min     =REX_VALUE[1];
$clang_id=REX_VALUE[2];
echo page_counter::modul_inp($min,$clang_id);
?>';
   $out='<?php
$min     =REX_VALUE[1];
$clang_id=REX_VALUE[2];
echo page_counter::modul_outp($min,$clang_id);
?>';
   return array('name'=>$name, 'input'=>$in, 'output'=>$out);
   }
public static function build_module($mypackage) {
   #   Erzeugen bzw. Aktualisieren eines Moduls in der Tabelle rex_module.
   #   $mypackage          Name des AddOns
   #   benutzte functions:
   #      self::define_module($mypackage)
   #
   # --- Modul-Quelle: name input, output
   $modul=self::define_module($mypackage);
   $name  =$modul['name'];
   $input =$modul['input'];
   $output=$modul['output'];
   #
   # --- existiert der Modul schon?
   $sql=rex_sql::factory();
   $table='rex_module';
   $query='SELECT * FROM '.$table.' WHERE name LIKE \'%'.$mypackage.'%\'';
   $mod=$sql->getArray($query);
   if(!empty($mod)):
     #     existiert schon: update (name bleibt unveraendert)
     $id=$mod[0]['id'];
     $update='UPDATE '.$table.' SET  input=\''.$input.'\'  WHERE id='.$id;
     $sql->setQuery($update);
     $update='UPDATE '.$table.' SET output=\''.$output.'\' WHERE id='.$id;
     $sql->setQuery($update);
     else:
     #     existiert nicht: insert
     $insert='INSERT INTO '.$table.' (name,input,output) '.
        'VALUES (\''.$name.'\',\''.$input.'\',\''.$output.'\')';
     $sql->setQuery($insert);
     endif;
   }
}
?>
