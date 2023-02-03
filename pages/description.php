<?php
/*
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Februar 2023
 */
echo '<div><b>Einbindung in Redaxo:</b></div>
<div class="counter_indent">Die Aufrufanzahl wird in der Spalte 
<code>'.page_counter::COUNTER.'</code> der Tabelle <code>rex_article</code>
gespeichert. Sie wird bei der Installation angelegt, bei der
De-Installation aber nicht wieder entfernt.<br/>
Für die Zählung von Aufrufen auf ausgewählte Artikel wird ein
Zähler-Modul zur Verfügung gestellt, der entsprechenden Artikeln
hinzugefügt werden muss. Er wird bei der Installation angelegt,
bei der De-Installation aber nicht wieder entfernt.</div>
<br/>
<div><b>Aufrufzählung bei allen Artikeln:</b></div>
<div class="counter_indent">Wird das AddOn zusammen mit Redaxo selbst
installiert, kann das Hochzählen im Seiten-Template vorgenommen
werden. Der Beginn der Zählung ergibt sich aus dem Datum, an dem
der Artikel angelegt wurde (Tabelle <code>rex_article</code>,
Spalte <code>createdate</code>).</div>
<br/>
<div><b>Aufrufzählung bei ausgewählten Artikeln:</b></div>
<div class="counter_indent">Dazu fügt man entsprechenden Artikeln
den Zähler-Modul hinzu. Dessen Anlegedatum (Tabelle
<code>rex_article_slice</code>, Spalte <code>createdate</code>)
definiert den Beginn der Zählung.</div>
<br/>
<div><b>Das AddOn liefert diese Daten:</b></div>
<div class="counter_indent">
- Anzahl Aufrufe seit Beginn der Zählung<br/>
- Datum des Beginns der Zählung<br/>
- Anzahl Tage seit Beginn der Zählung (abgeleitet)<br/>
- mittlere Anzahl Aufrufe pro Tag (abgeleitet, gerundet)</div>';
?>