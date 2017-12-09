<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Dezember 2017
 */
#
# --- Funktionen
$string='
<div><b>Der Z�hler-Modul nutzt die beiden folgenden PHP-Funktionen:
</b></div>
<div style="padding-left:15px;">
<code>function counter_get($art_id,$clang_id)</code></div>
<div style="padding-left:40px;">
Gibt alle ben�tigten Daten f�r die Aufrufstatistik zur Sprachversion
eines Artikels als assoziatives Array zur�ck (Startdatum der Z�hlung,
Anzahl der Aufrufe, Anzahl Tage seit dem Startdatum, Anzahl der
Aufrufe pro Tag) in demselben Format wie die Funktion
<tt>counter_collect()</tt> (vergl. unten).</div>
<div style="padding-left:15px;">
<code>function counter_set($art_id,$clang_id)</code></div>
<div style="padding-left:40px;">
Erh�ht die Anzahl der Aufrufe auf die Sprachversion eines Artikels
um 1 (nur im Frontend-Zweig). Die Funktion ist im Z�hler-Modul
enthalten. F�r den vorherigen Stand der Z�hlung wird die Funktion
<tt>counter_get($art_id,$clang_id)</tt> aufgerufen.</div>
<br/>
<div><b>Die folgenden PHP-Funktionen k�nnen dazu benutzt werden,
Aufrufstatistiken zu erstellen und auszugeben:</b></div>
<div style="padding-left:15px;">
<code>function counter_collect()</code></div>
<div style="padding-left:40px;">
Gibt die unten aufgelisteten Daten zu allen Artikeln zur�ck, die
mit dem Aufrufz�hler-Modul versehenen sind (als nummeriertes Array,
Nummerierung beginnend bei 1). Jedes Array-Element ist selbst ein
assoziatives Array mit diesen Elementen:
<div style="padding-left:20px;">
<table>
    <tr><td>[id]</td>
        <td>Id des Artikels</td></tr>
    <tr><td>[clang_id]</td>
        <td>Sprach-Id des Artikels</td></tr>
    <tr><td>[since]</td>
        <td>Datum des Beginns der Z�hlung</td></tr>
    <tr><td>[count]</td>
        <td>Anzahl der Aufrufe</td></tr>
    <tr><td>[days]</td>
        <td>Anzahl Tage seit Einrichtung des Artikels/des
            Z�hler-Moduls</td></tr>
    <tr><td>[daycount] &nbsp; &nbsp;</td>
        <td>Anzahl der Aufrufe pro Tag (gerundet)</td></tr>
</table>
</div>
</div>
<div style="padding-left:15px;">
<code>function counter_out()</code></div>
<div style="padding-left:40px;">
Gibt exemplarisch alle verf�gbaren aktuellen Aufrufzahlen tabellarisch
aus, basierend auf der Funktion <tt>counter_collect()</tt>. F�r die
Bereitstellung anderer Ausgabeformate kann der Quellcode der Funktion
als Vorlage benutzt werden.</div>
';
echo utf8_encode($string);
?>
