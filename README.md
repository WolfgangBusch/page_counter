# page_counter
<h3>Einfacher Aufrufzähler für Redaxo 5</h3>

<p>Dieses AddOn bietet eine einfache Möglichkeit, die Aufrufe auf
Artikel zu zählen, jeweils getrennt nach Sprachversionen. Die Anzahl
der Aufrufe wird in einer zusätzlichen Spalte der Tabelle
<tt>rex_article</tt> mitgeführt.</p>

<p>Wird das AddOn zusammen mit Redaxo selbst installiert, bietet
es sich an, grundsätzlich die Aufrufe auf alle Artikel zu sammeln.
Alternativ kann man sich darauf beschränken, die Aufrufe auf
ausgewählte Artikel zu zählen.</p>

<p>Mittels PHP-Funktionen können Aufrufzahlen und Aufrufhäufigkeiten
tabellarisch ausgegeben werden.</p>

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
