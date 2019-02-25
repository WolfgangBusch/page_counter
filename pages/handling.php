<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Februar 2019
 */
#
# --- Funktionen
$string='
<div><b>Der Zähler-Modul nutzt die beiden folgenden PHP-Funktionen:
</b></div>
<div style="padding-left:15px;">
<code>function counter_get($art_id,$clang_id)</code></div>
<div style="padding-left:40px;">
Gibt alle benötigten Daten für die Aufrufstatistik zur Sprachversion
eines Artikels als assoziatives Array zurück (Startdatum der Zählung,
Anzahl der Aufrufe, Anzahl Tage seit dem Startdatum, Anzahl der
Aufrufe pro Tag) in demselben Format wie die Funktion
<tt>counter_collect()</tt> (vergl. unten).</div>
<div style="padding-left:15px;">
<code>function counter_set($art_id,$clang_id)</code></div>
<div style="padding-left:40px;">
Erhöht die Anzahl der Aufrufe auf die Sprachversion eines Artikels
um 1 (nur im Frontend-Zweig). Die Funktion ist im Zähler-Modul
enthalten. Für den vorherigen Stand der Zählung wird die Funktion
<tt>counter_get($art_id,$clang_id)</tt> aufgerufen.</div>
<br/>
<div><b>Die folgenden PHP-Funktionen können dazu benutzt werden,
Aufrufstatistiken zu erstellen und auszugeben:</b></div>
<div style="padding-left:15px;">
<code>function counter_collect()</code></div>
<div style="padding-left:40px;">
Gibt die unten aufgelisteten Daten zu allen Artikeln zurück, die
mit dem Aufrufzähler-Modul versehenen sind (als nummeriertes Array,
Nummerierung beginnend bei 1). Jedes Array-Element ist selbst ein
assoziatives Array mit diesen Elementen:
<div style="padding-left:20px;">
<table>
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
<div style="padding-left:15px;">
<code>function counter_out()</code></div>
<div style="padding-left:40px;">
Gibt exemplarisch alle verfügbaren aktuellen Aufrufzahlen tabellarisch
aus, basierend auf der Funktion <tt>counter_collect()</tt>. Für die
Bereitstellung anderer Ausgabeformate kann der Quellcode der Funktion
als Vorlage benutzt werden.</div>
';
echo $string;
?>
