<?php
/*
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version April 2023
 */
echo '<div><b>Einbindung in Redaxo:</b></div>
<div class="counter_indent">
Die Anzahl der Aufrufe eines Artikels wird in der Tabelle
<code>rex_article</code> in einer zusätzlichen Spalte
<code>'.page_counter::COUNTER.'</code> gespeichert. Sie wird
bei der Installation angelegt, bei der De-Installation aber
nicht wieder entfernt.<br>
Um die Aufrufe auf ausgewählte Artikel zu zählen, wird diesen
ein Block hinzugefügt, der die Zählerfunktion enthält
(&quot;Zählerblock&quot;). Der zugehörige Modul wird bei der
Installation angelegt. Um die Aufrufe eines jeden Artikels
zu erfassen, wird die Zählerfunktion stattdessen in das
Seiten-Template eingefügt.</div>

<div><br><b>Die Hitliste der Aufrufzahlen</b></div>
<div class="counter_indent">
liefert für jeden Artikel diese Daten:
<ul style="margin:0;">
    <li>Anzahl Aufrufe seit Beginn der Zählung</li>
    <li>Datum des Beginns der Zählung</li>
    <li>Anzahl Tage seit Beginn der Zählung (abgeleitet)</li>
    <li>mittlere Anzahl Aufrufe pro Tag (abgeleitet, gerundet)</li>
</ul>
Der Beginn der Zählung entspricht entweder dem Erstellungsdatum
des Zählerblocks oder des Artikels.<br>
&nbsp;</div>';
?>