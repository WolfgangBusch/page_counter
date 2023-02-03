<?php
/*
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Februar 2023
 */
$myaddon=$this->getPackageId();
echo '<div><b>Zähler-Modul:</b></div>
<div class="counter_indent">
Im <b>Backend</b> wird eine Kurzfassung der gesammelten Zählerdaten für den
Artikel (in der jeweiligen Sprachversion) angezeigt: Startdatum der Zählung,
Anzahl der Aufrufe, Anzahl Tage seit dem Startdatum, Anzahl der Aufrufe pro
Tag. Sie werden von der folgenden Funktion zurück gegeben:
   <div class="counter_indent">
   <code>$data = '.$myaddon.'::counter_get($art_id,$clang_id);</code></div>
</div>
<div class="counter_indent">
Im <b>Frontend</b> erhöht der Aufruf der folgenden Funktion den Zähler
für die jeweilige Sprachversion um 1:
   <div class="counter_indent">
   <code>'.$myaddon.'::counter_set($art_id,$clang_id);</code></div>
</div>

<br>
<div><b>Zähler im Seiten-Template:</b></div>
<div class="counter_indent">
Wenn grundsätzlich jeder Aufruf jedes Artikels mitgezählt werden soll,
muss nur die PHP-Zeile
   <div class="counter_indent">
   <code>'.$myaddon.'::counter_set($art_id,$clang_id);</code></div>
im Seiten-Template eingefügt werden.
</div>

<br>
<div><b>AddOn-Funktionen für Aufrufstatistiken:</b></div>
<div class="counter_indent">
<code>$data = '.$myaddon.'::counter_collect();</code>
   <div class="counter_indent">
   Gibt zu allen Artikeln, die mit dem Aufrufzähler-Modul versehen sind,
   die unten aufgeführten Daten zurück (als nummeriertes Array,
   Nummerierung ab 1). Jedes Array-Element ist selbst ein assoziatives
   Array:
      <div class="counter_indent">
      <table class="counter_table">
          <tr><td>S c h l ü s s e l</td>
              <td class="counter_indent">W e r t</td></tr>
          <tr><td><tt>[\'id\']</tt></td>
              <td class="counter_indent">Id des Artikels</td></tr>
          <tr><td><tt>[\'clang_id\']</tt></td>
              <td class="counter_indent">Sprach-Id des Artikels</td></tr>
          <tr><td><tt>[\'since\']</tt></td>
              <td class="counter_indent">Datum des Beginns der Zählung
                  <tt>(tt.mm.jjjj)</tt></td></tr>
          <tr><td><tt>[\'count\']</tt></td>
              <td class="counter_indent">Anzahl der Aufrufe</td></tr>
          <tr><td><tt>[\'days\']</tt></td>
              <td class="counter_indent">Anzahl Tage seit Einrichtung des
                  Artikels bzw. Einfügen des Zähler-Moduls</td></tr>
          <tr><td><tt>[\'daycount\']</tt></td>
              <td class="counter_indent">durchschnittliche Anzahl der
                  Aufrufe pro Tag (gerundet)</td></tr>
      </table></div>
   </div>
</div>
<div class="counter_indent">
<code>'.$myaddon.'::counter_out();</code>
   <div class="counter_indent">
   Diese Funktion liefert exemplarisch eine Auswertung in Form einer
   tabellarischen Ausgabe aller verfügbaren aktuellen Aufrufzahlen. Sie
   basiert auf der vorherigen Funktion und ist nur im Falle der Zählung
   von Aufrufen ausgewählter Seiten nutzbar. Ihr Quellcode kann auch als
   Vorlage für die Bereitstellung anderer Ausgabeformate dienen.</div>
</div>';
?>
