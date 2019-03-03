<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version März 2019
 */
$myaddon=$this->getPackageId();
echo '<div><b>Der Zähler-Modul nutzt die beiden folgenden PHP-Funktionen:
</b></div>
<div class="counter_indent">
<code>'.$myaddon.'::counter_get($art_id,$clang_id)</code>
<div class="counter_indent">Gibt alle benötigten Daten für die Aufrufstatistik zur
Sprachversion eines Artikels als assoziatives Array zurück (Startdatum
der Zählung, Anzahl der Aufrufe, Anzahl Tage seit dem Startdatum,
Anzahl der Aufrufe pro Tag) in demselben Format wie die Funktion
<tt>'.$myaddon.'::counter_collect</tt> (vergl. unten).</div>
<code>'.$myaddon.'::counter_set($art_id,$clang_id)</code>
<div style="padding-left:20px;">
Erhöht die Anzahl der Aufrufe auf die Sprachversion eines Artikels
um 1 (nur im Frontend-Zweig). Die Funktion ist im Zähler-Modul
enthalten. Für den vorherigen Stand der Zählung wird die Funktion
<tt>'.$myaddon.'::counter_get</tt> (vergl. oben) aufgerufen.</div>
</div>
<br/>
<div><b>Die folgenden PHP-Funktionen können dazu benutzt werden,
Aufrufstatistiken zu erstellen und auszugeben:</b></div>
<div class="counter_indent">
<code>'.$myaddon.'::counter_collect()</code>
<div class="counter_indent">Gibt zu allen Artikeln, die mit dem Aufrufzähler-Modul
versehenen sind, die unten aufgeführten Daten zurück (als nummeriertes
Array, Nummerierung beginnend bei 1). Jedes Array-Element ist selbst
ein assoziatives Array mit diesen Elementen:
<div class="counter_indent">
<table style="background-color:inherit;">
    <tr><td>[\'id\']</td>
        <td>Id des Artikels</td></tr>
    <tr><td>[\'clang_id\']</td>
        <td>Sprach-Id des Artikels</td></tr>
    <tr><td>[\'since\']</td>
        <td>Datum des Beginns der Zählung</td></tr>
    <tr><td>[\'count\']</td>
        <td>Anzahl der Aufrufe</td></tr>
    <tr><td>[\'days\']</td>
        <td>Anzahl Tage seit Einrichtung des Artikels/des
            Zähler-Moduls</td></tr>
    <tr><td>[\'daycount\'] &nbsp; &nbsp;</td>
        <td>Anzahl der Aufrufe pro Tag (gerundet)</td></tr>
</table>
</div>
</div>
</div>
<div class="counter_indent">
<code>'.$myaddon.'::counter_out()</code>
<div class="counter_indent">Gibt exemplarisch alle verfügbaren aktuellen Aufrufzahlen
tabellarisch aus, basierend auf der Funktion <tt>'.$myaddon.'::counter_collect()</tt>.
Der Quellcode der Funktion kann auch als Vorlage für die Bereitstellung
anderer Ausgabeformate benutzt werden.</div>
</div>';
?>
