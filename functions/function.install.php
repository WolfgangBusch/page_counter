<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Dezember 2017
 */
define("COUNTER","art_counter");    // Name der rex_article-Spalte
#
function counter_sql_action($sql,$query) {
   #   Ausfuehrung einer SQL-Aktion mittels setQuery()
   #   ggf. Ausgabe einer Fehlermeldung
   #   $sql               SQL-Handle
   #   $query             SQL-Aktion
   #
   try {
        $sql->setQuery($query);
        $error="";
         } catch(rex_sql_exception $e) {
        $error=$e->getMessage();
        }
   if(!empty($error)) echo rex_view::error($error);
   }
function counter_define_modul_out() {
   #   Rueckgabe der Quelle des (Output-Teils des) Aufrufzaehler-Moduls
   #
   $string=
'<?php
$art_id  =$this->getValue("article_id");
$clang_id=$this->getValue("clang_id");
if(!rex::isBackend()):            // Zaehler nur im Frontend
  counter_set($art_id,$clang_id);
  else:                           // Erfolgsmeldungen nur im Backend
  $anz=counter_get($art_id,$clang_id);
  echo "<div><b>$anz[count]</b> Aufrufe &nbsp; ".
     "(seit $anz[since], in $anz[days] Tagen &nbsp; - &nbsp; ".
     "ca. $anz[daycount] Aufrufe pro Tag)</b></div>\\\n";
  endif;
?>';
   return $string;
   }
function counter_insert_counter_column() {
   #   Einfuegen der Aufrufzaehler-Spalte in rex_article, falls diese
   #   noch nicht vorhanden ist
   #
   $table="rex_article";
   $sql=rex_sql::factory();
   $sql->setTable($table);
   $art=$sql->getArray("SELECT * FROM $table");
   $keys=array_keys($art[0]);
   $vorh=FALSE;
   for($i=0;$i<count($keys);$i=$i+1) if($keys[$i]==COUNTER) $vorh=TRUE;
   if(!$vorh) counter_sql_action($sql,"ALTER TABLE ".$table." ADD ".COUNTER." INT");
   }
function counter_insert_module($mypackage) {
   #   Erzeugen des Moduls zum Einfuegen des Aufrufzaehlers in einen Artikel
   #   benutzte functions:
   #      counter_define_modul_out()
   #
   # --- Modul-Inhalt (output)
   $out=counter_define_modul_out();
   $sql=rex_sql::factory();
   $table="rex_module";
   $modname=utf8_encode("Aufrufzähler (".$mypackage.")");
   #
   # --- existiert der Modul schon?
   $query="SELECT * FROM ".$table." WHERE name LIKE '%".$mypackage."%'";
   $mod=$sql->getArray($query);
   if(count($mod[0])>0):
     #     existiert schon: update
     counter_sql_action($sql,"UPDATE ".$table." SET output='".$out."' ".
        "WHERE id=".$mod[0][id]);
     else:
     #     existiert nicht: insert
     counter_sql_action($sql,"INSERT INTO ".$table." (name,input,output) ".
        "VALUES ('".$modname."','','".$out."')");
     endif;
   }
?>
