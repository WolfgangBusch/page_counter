<?php
/**
 * Aufrufzaehler Addon
 * @author wolfgang[at]busch-dettum[dot]de Wolfgang Busch
 * @package redaxo5
 * @version Dezember 2017
 */
#
$string='
<p>Dieses AddOn bietet eine einfache M�glichkeit, die Aufrufe auf
Artikel zu z�hlen, jeweils getrennt nach Sprachversionen. Die Anzahl
der Aufrufe wird in einer zus�tzlichen Spalte der Tabelle
<tt>rex_article</tt> mitgef�hrt.</p>

<p>Wird das AddOn zusammen mit Redaxo selbst installiert, bietet
es sich an, grunds�tzlich die Aufrufe auf alle Artikel zu sammeln.
Alternativ kann man sich darauf beschr�nken, die Aufrufe auf
ausgew�hlte Artikel zu z�hlen.</p>

<p>Mittels PHP-Funktionen k�nnen Aufrufzahlen und Aufrufh�ufigkeiten
tabellarisch ausgegeben werden.</p>
';
echo utf8_encode($string);
?>
