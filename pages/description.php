<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Dezember 2017
 */
#
# --- Beschreibung
$string='
<div><b>Einbindung in Redaxo:</b></div>
<div style="padding-left:20px;">Die Aufrufanzahl wird in der Spalte
<tt>art_counter</tt> der Tabelle <tt>rex_article</tt> gespeichert. Sie
wird bei der Installation angelegt, bei der De-Installation aber nicht
wieder entfernt.<br/>
Für die Zählung von Aufrufen auf ausgewählte Artikel wird ein
Zähler-Modul zur Verfügung gestellt, der entsprechenden Artikeln
hinzugefügt werden muss. Er wird bei der Installation angelegt, bei
der De-Installation aber nicht wieder entfernt.</div>
<br/>
<div><b>Aufrufzählung bei allen Artikeln:</b></div>
<div style="padding-left:20px;">
Wird das AddOn zusammen mit Redaxo selbst installiert, kann das
Hochzählen im Seiten-Template vorgenommen werden. Der Beginn der
Zählung ergibt sich aus dem Datum, an dem der Artikel angelegt wurde
(Tabelle <tt>rex_article</tt>, Spalte <tt>createdate</tt>).</div>
<br/>
<div><b>Aufrufzählung bei ausgewählten Artikeln</b></div>
<div style="padding-left:20px;">
Dazu fügt man entsprechenden Artikeln den Zähler-Modul hinzu.
Dessen Anlegedatum (Tabelle <tt>rex_article_slice</tt>, Spalte
<tt>createdate</tt>) liefert den Beginn der Zählung.</div>
<br/>
<div><b>Verfügbare statistische Daten:</b></div>
<div <style="padding-left:20px;">
<ul>
    <li>Anzahl Aufrufe seit Beginn der Zählung</li>
    <li>Datum des Beginns der Zählung</li>
    <li>Anzahl Tage seit Beginn der Zählung (abgeleitet)</li>
    <li>mittlere Anzahl Aufrufe pro Tag (abgeleitet, gerundet)</li>
</ul>
</div>
';
echo utf8_encode($string);
?>
