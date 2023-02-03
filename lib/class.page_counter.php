<?php
/*
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Februar 2023
 */
class page_counter {
#
const COUNTER='art_counter';    // Name der rex_article-Spalte
#
public static function counter_mod_id() {
   #   Rueckgabe der Modul-Id des Aufrufzaehler-Moduls
   #
   $sql=rex_sql::factory();
   $query='SELECT * FROM rex_module WHERE output '.
      'LIKE \'%page_counter::counter_set(\$art_id,%\'';
   $result=$sql->getArray($query);
   $modul=$result[0];
   return $modul['id'];
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
   #          ['since']    Datum der Einrichtung der Seite/des Zaehler-Moduls
   #          ['count']    Anzahl der Aufrufe
   #          ['days']     Anzahl Tage seit Einrichtung der Seite/des Zaehler-Moduls
   #          ['daycount'] Anzahl der Aufrufe pro Tag
   #   $art_id             Id der betreffenden Seite
   #   $clang_id           Sprach-Id der betreffenden Seite
   #   benutzte functions:
   #      self::counter_mod_id();
   #
   $modtyp=self::counter_mod_id();   // Id des Aufrufzaehler-Moduls
   $sql=rex_sql::factory();
   #
   # --- Artikel heraussuchen
   $query='SELECT * FROM rex_article WHERE id='.$art_id.' AND clang_id='.$clang_id;
   $result=$sql->getArray($query);
   $article=$result[0];
   #
   # --- Aufrufzaehlung seit (ALLE Artikelaufrufe per Seitentemplate gezaehlt)
   $date=$article['createdate'];     // Format (Redaxo 5): 2017-12-08 19:31:46
   $date=strtotime($date);           // Wandlung in UNIX-Timestamp
   #
   # --- Aufrufzaehlung seit (nur Aufrufe von Artikeln mit Zaehlermodul gezaehlt)
   $query='SELECT * FROM rex_article_slice '.
      'WHERE article_id='.$art_id.' AND module_id='.$modtyp;
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
public static function counter_set($art_id,$clang_id) {
   #   Erhoehung der Anzahl Aufrufe auf eine Seite
   #   (wird nur im Frontend durchgefuehrt)
   #   Die Anzahl der Aufrufe einer Seite ist gespeichert in der
   #   Spalte self::COUNTER der Tabelle 'rex_article'
   #   $art_id             Id der betreffenden Seite
   #   $clang_id           Sprach-Id der betreffenden Seite
   #   benutze functions:
   #      self::counter_get($art_id,$clang_id);
   #
   $res=FALSE;
   if(!rex::isBackend()):
     # --- Zaehler auslesen
     $count=self::counter_get($art_id,$clang_id);
     $anz=$count['count'];
     #
     # --- Zaehler um 1 erhoehen und zurueckschreiben
     $anz=$anz+1;
     $sql=rex_sql::factory();
     $table='rex_article';
     $where ='id='.$art_id.' AND clang_id='.$clang_id;
     $update='UPDATE '.$table.' SET '.self::COUNTER.'='.$anz.' WHERE '.$where;
     $sql->setQuery($update);
     endif;
   }
public static function counter_get_articles_of_module($id) {
   #   Rueckgabe der Ids und der Sprach-Ids von Artikeln, die einen gegebenen
   #   Modul enthalten, in Form eines nummerierten Arrays (Nummerierung ab 1),
   #   wobei jedes Array-Element aus einem nummerierten Array besteht
   #   ([0]=>article_id, [1]=>clang_id).
   #   $id                 Id des betreffenden Moduls
   #
   # --- alle Artikel-Slices heraussuchen, deren modul_typ = der Modul-Id sind
   #     ein Artikel-Slice enthaelt die Id des zugehoerigen Artikels
   $sql=rex_sql::factory();
   $rows=$sql->getArray('SELECT * FROM rex_article_slice WHERE module_id='.$id);
   $arts=array();
   for($i=0;$i<count($rows);$i=$i+1)
      $arts[$i+1]=array($rows[$i]['article_id'],$rows[$i]['clang_id']);
   return $arts;
   }
public static function counter_collect() {
   #   Rueckgabe aller Artikel, die mit dem Aufrufzaehler-Modul
   #   versehenen sind, als nummeriertes Array
   #   (Nummerierung beginnend bei 1) in dieser Form:
   #      $anz[$i]['id']       = Id des Artikels
   #              ['clang_id'] = Sprach-Id des Artikels
   #              ['count']    = Anzahl der Aufrufe
   #              ['since']    = Datum des Beginns der Zaehlung
   #              ['days']     = Anzahl Tage seit Einrichtung der Seite/des Zaehler-Moduls
   #              ['daycount'] = Anzahl der Aufrufe pro Tag
   #   Das Array ist nach der Aufrufanzahl (absteigend) sortiert
   #   benutzte functions:
   #      self::counter_mod_id()
   #      self::counter_get_articles_of_module($id)
   #      self::counter_get($art_id,$clang_id)
   #
   # --- alle Artikel ermitteln, die mit dem Aufrufzaehler-Modul versehen sind
   $arts=self::counter_get_articles_of_module(self::counter_mod_id());
   for($i=1;$i<=count($arts);$i=$i+1):
      $art_id=$arts[$i][0];
      $clang_id=$arts[$i][1];
      $anz=self::counter_get($art_id,$clang_id);
      $count[$i]=$anz['count'];
      $art[$i]=array('id'=>$art_id, 'clang_id'=>$clang_id, 'count'=>$anz['count'],
         'since'=>$anz['since'], 'days'=>$anz['days'], 'daycount'=>$anz['daycount']);
      endfor;
   #
   # --- nach der Anzahl Aufrufe sortieren
   array_multisort($count,SORT_DESC,$art);
   for($i=0;$i<count($art);$i=$i+1) $brt[$i+1]=$art[$i];
   return $brt;
   }
public static function counter_out() {
   #   Ausgabe der aktuellen Aufrufzahlen der Seiten, die mittels
   #   Aufrufzaehler-Modul gezaehlt werden
   #   benutzte functions:
   #      self::counter_collect()
   #
   $arts=self::counter_collect();
   #
   echo '<h3 align="center">Aufrufzähler für ausgewählte Seiten</h3>
<table class="counter_table">
    <tr valign="bottom">
        <td class="counter_nowrap"><b><u>Seite</u></b></td>
        <td class="counter_right" ><b>Anzahl<br/><u>insgesamt</u></b></td>
        <td class="counter_right" ><b>Aufrufe<br/><u>pro Tag</u></b></td>
        <td class="counter_right" ><b><u>seit</u></b></td>
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
      $url=rex_getUrl($art_id,$clang_id);
      $string='<a href="'.$url.'" target="_blank">'.$url.'</a>'.$clang;
      echo '
    <tr><td class="counter_nowrap">'.$string.':</td>
        <td class="counter_right" ><span class="counter_red">'.$count.'</span></td>
        <td class="counter_right" >&sim; <span class="counter_red">'.$daycount.'</span></td>
        <td class="counter_right" ><tt> &nbsp; '.$since.'</tt></td>
        <td class="counter_right" > &nbsp; <small>('.$days.' Tage)</small></td></tr>';
      endfor;
   echo '
</table>';
   }
}
?>
