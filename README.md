# page_counter
<h3>Einfacher Aufrufz�hler f�r Redaxo 5</h3>

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

<div><b>Einbindung in Redaxo:</b></div>
<div style="padding-left:20px;">Die Aufrufanzahl wird in der Spalte
<tt>art_counter</tt> der Tabelle <tt>rex_article</tt> gespeichert. Sie
wird bei der Installation angelegt, bei der De-Installation aber nicht
wieder entfernt.<br/>
F�r die Z�hlung von Aufrufen auf ausgew�hlte Artikel wird ein
Z�hler-Modul zur Verf�gung gestellt, der entsprechenden Artikeln
hinzugef�gt werden muss. Er wird bei der Installation angelegt, bei
der De-Installation aber nicht wieder entfernt.</div>
<br/>
<div><b>Aufrufz�hlung bei allen Artikeln:</b></div>
<div style="padding-left:20px;">
Wird das AddOn zusammen mit Redaxo selbst installiert, kann das
Hochz�hlen im Seiten-Template vorgenommen werden. Der Beginn der
Z�hlung ergibt sich aus dem Datum, an dem der Artikel angelegt wurde
(Tabelle <tt>rex_article</tt>, Spalte <tt>createdate</tt>).</div>
<br/>
<div><b>Aufrufz�hlung bei ausgew�hlten Artikeln</b></div>
<div style="padding-left:20px;">
Dazu f�gt man entsprechenden Artikeln den Z�hler-Modul hinzu.
Dessen Anlegedatum (Tabelle <tt>rex_article_slice</tt>, Spalte
<tt>createdate</tt>) liefert den Beginn der Z�hlung.</div>
<br/>
<div><b>Verf�gbare statistische Daten:</b></div>
<div <style="padding-left:20px;">
<ul>
    <li>Anzahl Aufrufe seit Beginn der Z�hlung</li>
    <li>Datum des Beginns der Z�hlung</li>
    <li>Anzahl Tage seit Beginn der Z�hlung (abgeleitet)</li>
    <li>mittlere Anzahl Aufrufe pro Tag (abgeleitet, gerundet)</li>
</ul>
</div>
