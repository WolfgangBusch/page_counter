<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Februar 2019
 */
define('COUNTER','art_counter');    // Name der rex_article-Spalte
#
function counter_sql_action($sql,$query) {
   #   Ausfuehrung einer SQL-Aktion mittels setQuery()
   #   ggf. Ausgabe einer Fehlermeldung
   #   $sql               SQL-Handle
   #   $query             SQL-Aktion
   #
   try {
        $sql->setQuery($query);
        $error='';
         } catch(rex_sql_exception $e) {
        $error=$e->getMessage();
        }
   if(!empty($error)) echo rex_view::error($error);
   }
function counter_insert_counter_column() {
   #   Einfuegen der Aufrufzaehler-Spalte in rex_article, falls diese
   #   noch nicht vorhanden ist
   #
   $table='rex_article';
   $cols=rex_sql::showColumns($table,$DBID=1);
   $vorh=FALSE;
   for($i=0;$i<count($cols);$i=$i+1) if($cols[$i]['name']==COUNTER) $vorh=TRUE;
   if(!$vorh):
     $sql=rex_sql::factory();
     counter_sql_action($sql,'ALTER TABLE '.$table.' ADD '.COUNTER.' INT');
     endif;
   }
function counter_define_module($mypackage) {
   #   Rueckgabe der Quelle des Aufrufzaehler-Moduls in Form eines
   #   assoziativen Arrays:
   #      $mod['name']     Titel/Name des Moduls
   #      $mod['input']    Input-Teil des Moduls
   #      $mod['output']   Output-Teil des Moduls
   #   $mypackage          Name des AddOns
   #
   $name='Aufrufzähler ('.$mypackage.')';
   $in='<p>Ab dem allerersten Speichern dieses Moduls werden die Aufrufe dieses Artikels gezählt.</p>';
   $out='<?php
$art_id  =$this->getValue("article_id");
$clang_id=$this->getValue("clang_id");
if(!rex::isBackend()):            // Zaehler nur im Frontend
  counter_set($art_id,$clang_id);
  else:                           // Erfolgsmeldungen nur im Backend
  $anz=counter_get($art_id,$clang_id);
  echo "<div><b>".$anz["count"]."</b> Aufrufe &nbsp; ".
     "(seit ".$anz["since"].", in ".$anz["days"]." Tagen &nbsp;".
     " - &nbsp; ca. ".$anz["daycount"]." Aufrufe pro Tag)</b></div>\n";
  endif;
?>';
   return array('name'=>$name, 'input'=>str_replace('\\','\\\\',$in), 'output'=>str_replace('\\','\\\\',$out));
   }
function counter_build_module($mypackage) {
   #   Erzeugen bzw. Aktualisieren eines Moduls in der Tabelle rex_module
   #   $mypackage          Name des AddOns
   #   benutzte functions:
   #      counter_define_module($mypackage)
   #
   $table='rex_module';
   #
   # --- Modul-Quelle: name input, output
   $modul=counter_define_module($mypackage);
   $name  =$modul['name'];
   $input =$modul['input'];
   $output=$modul['output'];
   #
   # --- existiert der Modul schon?
   $sql=rex_sql::factory();
   $query='SELECT * FROM '.$table.' WHERE name LIKE \'%'.$mypackage.'%\'';
   $mod=$sql->getArray($query);
   if(!empty($mod)):
     #     existiert schon: update (name bleibt unveraendert)
     $id=$mod[0]['id'];
     counter_sql_action($sql,'UPDATE '.$table.' SET  input=\''.$input.'\'  WHERE id='.$id);
     counter_sql_action($sql,'UPDATE '.$table.' SET output=\''.$output.'\' WHERE id='.$id);
     else:
     #     existiert nicht: insert
     counter_sql_action($sql,'INSERT INTO '.$table.' (name,input,output) '.
        'VALUES (\''.$name.'\',\''.$input.'\',\''.$output.'\')');
     endif;
   }
?>