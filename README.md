# page_counter
<h3>Einfacher Aufrufzähler für Redaxo 5</h3>

<p>Dieses AddOn bietet eine einfache Möglichkeit, die Aufrufe von
Artikeln zu zählen, jeweils getrennt nach Sprachversionen. Die Anzahl
der Aufrufe wird in einer zusätzlichen Spalte der Tabelle
<tt>rex_article</tt> mitgeführt.</p>

<p>Wird das AddOn zusammen mit Redaxo selbst installiert, bietet
es sich an, grundsätzlich für jeden Artikel alle Aufrufe zu sammeln.
Alternativ kann man sich darauf beschränken, die Aufrufe von
ausgewählten Artikeln zu zählen.</p>

<div><b>Einbindung in Redaxo:</b></div>
<div>Die Aufrufanzahl wird in der Spalte <code>art_counter</code>
der Tabelle <code>rex_article</code> gespeichert. Sie wird bei
der Installation angelegt, bei der De-Installation aber nicht wieder
entfernt.<br/>
Für die Zählung von Aufrufen auf ausgewählte Artikel wird ein
Zähler-Modul zur Verfügung gestellt, der entsprechenden Artikeln
hinzugefügt werden muss. Er wird bei der Installation angelegt, bei
der De-Installation aber nicht wieder entfernt.</div>
<br/>
<div><b>Aufrufzählung bei allen Artikeln:</b></div>
<div>Wird das AddOn zusammen mit Redaxo selbst installiert, kann das
Hochzählen im Seiten-Template vorgenommen werden. Der Beginn der
Zählung ergibt sich aus dem Datum, an dem der Artikel angelegt wurde
(Tabelle <code>rex_article</code>, Spalte <code>createdate</code>).</div>
<br/>
<div><b>Aufrufzählung bei ausgewählten Artikeln</b></div>
<div>Dazu fügt man entsprechenden Artikeln den Zähler-Modul hinzu.
Dessen Anlegedatum (Tabelle <code>rex_article_slice</code>, Spalte
<code>createdate</code>) liefert den Beginn der Zählung.</div>
<br/>
<div><b>Das AddOn liefert diese Daten:</b></div>
<div>- Anzahl Aufrufe seit Beginn der Zählung<br/>
- Datum des Beginns der Zählung<br/>
- Anzahl Tage seit Beginn der Zählung (abgeleitet)<br/>
- mittlere Anzahl Aufrufe pro Tag (abgeleitet, gerundet)</div>