<?php
/*
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version April 2023
 */
$addon=$this->getPackageId();
echo '
<div><b>Der AddOn-Modul:</b></div>
<div class="counter_indent">
Das AddOn richtet einen Modul ein, der wahlweise eingesetzt werden
kann
<ul style="margin:0;">
    <li>für die Einrichtung eines Zählerblocks in einem Artikel
        (zeigt außerdem im Backend den aktuellen Zählerstand für den
        Artikel an) oder</li>
    <li>für die Ausgabe der Aufruf-Hitliste (nur im Frontend)</li>
</ul>
Dieser Modul wird bei der De-Installation nicht wieder entfernt.
Welche Funktion der Block wahrnehmen soll, wird durch den Wert
eines Input-Feldes entschieden.</div>

<div><br><b>Zählerfunktion im Seiten-Template:</b></div>
<div class="counter_indent">
Wenn grundsätzlich jeder Aufruf jedes Artikels mitgezählt werden
soll, muss ein Aufruf der Zählerfunktion <tt>set_counter()</tt>
als PHP-Code in das Seiten-Template eingefügt werden.
Eine geeignete Stelle dafür ist z.B. die erste Zeile im Template,
die dann so lautet:
<div class="counter_indent">
<code>&lt;?php '.$addon.'::set_counter(); ?&gt;</code></div>
</div>

<div><br><b>Aufruf-Hitliste:</b></div>
<div class="counter_indent">
Der AddOn-Modul gibt die aktuelle Aufruf-Hitliste im Frontend aus,
wenn im Input-Feld für die Mindestanzahl von Aufrufen ein positiver
Wert eingegeben wird. Dabei können Artikel verschiedener Sprachen
wahlweise getrennt oder zusammen aufgelistet werden. Die Darstellung
der Hitliste ist fest formatiert. Für eine eigene Gestaltung können
die folgenden Hinweise benutzt werden.</div>

<div><br><b>Individuelle Gestaltung der Aufruf-Hitliste:</b></div>
<div class="counter_indent">
Dazu muss die AddOn-Funktion <code>'.$addon.'::counter_out($min,$clang_id)</code>
angepasst werden.
    <table class="counter_table">
        <tr valign="top">
            <td><code>$min</code></td>
            <td class="counter_indent">
                Mindestanzahl der bisher erfolgten Aufrufe, Artikel
                mit weniger Aufrufen werden nicht ausgegeben
                (= Wert des Input-Feldes im Modul)</td></tr>
        <tr valign="top">
            <td><code>$clang_id</code></td>
            <td class="counter_indent">
                Sprach-Id (= Wert des Select-Menüs im Modul)<br>
                &gt;0: nur Artikel dieser Sprache werden aufgelistet<br>
                &le;0: Artikel aller Sprachen werden aufgelistet</td></tr>
    </table>
    Die Funktion bezieht die gespeicherten Zählerdaten über den Aufruf<br>
    <code>$data = '.$addon.'::counter_collect($min,$clang_id);</code> und
    formatiert die Hitliste als HTML-Tabelle.
    <table class="counter_table">
        <tr valign="top">
            <td><code>$data</code></td>
            <td class="counter_indent" colspan="2">
                Nummeriertes Array der Zählerdaten der Artikel
                (Nummerierung ab 1). Das Array ist <b>nach Aufrufanzahl
                sortiert</b>. Jedes Array-Element ist selbst ein
                assoziatives Array:</td></tr>
        <tr valign="top">
            <td></td>
            <td class="counter_indent" width="1">
                <u>Schlüssel</u></td>
            <td class="counter_indent">
                <u>Wert</u></td></tr>
        <tr valign="top">
            <td></td>
            <td class="counter_indent" width="1">
                <tt>[\'id\']</tt></td>
            <td class="counter_indent">
                Id des Artikels</td></tr>
        <tr valign="top">
            <td></td>
            <td class="counter_indent" width="1">
                <tt>[\'clang_id\']</tt></td>
            <td class="counter_indent">
                Sprach-Id des Artikels</td></tr>
        <tr valign="top">
            <td></td>
            <td class="counter_indent" width="1">
                <tt>[\'since\']</tt></td>
            <td class="counter_indent">
                Datum des Beginns der Zählung
                <tt>(tt.mm.jjjj)</tt></td></tr>
        <tr valign="top">
            <td></td>
            <td class="counter_indent" width="1">
                <tt>[\'count\']</tt></td>
            <td class="counter_indent">
                Anzahl der Aufrufe</td></tr>
        <tr valign="top">
            <td></td>
            <td class="counter_indent" width="1">
                <tt>[\'days\']</tt></td>
            <td class="counter_indent">
                Anzahl Tage seit Einrichtung des Artikels bzw.
                Einfügen des Zähler-Moduls</td></tr>
        <tr valign="top">
            <td></td>
            <td class="counter_indent" width="1">
                <tt>[\'daycount\']</tt></td>
            <td class="counter_indent">
                durchschnittliche Anzahl der Aufrufe pro Tag
                (gerundet)</td></tr>
      </table>
   </div>
<br>&nbsp;</div>';
?>
