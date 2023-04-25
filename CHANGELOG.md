# page_counter
<h4>Version 1.4</h4>
<ul>
    <li>Die function counter_set($art_id,$clang_id) ist ersetzt durch
        die function set_counter(). ***Der entsprechende Aufruf im
        Seiten-Template muss mit der Übernahme dieser AddOn-Version
        korrigiert werden!***</li>
    <li>Es kann jetzt eine Mindestanzahl von Aufrufen angegeben werden,
        die ein Artikel haben muss, um in der Aufrufstatistik zu
        erscheinen. Außerdem kann die Aufrufstatistik jetzt auf einzelne
        Sprachversionen beschränkt werden.</li>
    <li>Der AddOn-Modul dient jetzt nicht nur zur Aktivierung der
        Aufrufzählung einzelner Artikel. Er kann wahlweise auch zur
        Ausgabe der Aufrufstatistik benutzt werden.</li>
    <li>Die Aufrufzählung wird jetzt sauber gemäß Sprachversion des
        Artikels durchgeführt.</li>
</ul>
<h4>Version 1.3.1</h4>
<ul>
    <li>Mit PHP Vers. 8 trat ein Fehler auf (... count(null) ...), der jetzt
        abgefangen ist.</li>
    <li>Die globale Variable COUNTER ist ersetzt durch eine Klassenkonstante.</li>
    <li>Die Beschreibung ist überarbeitet.</li>
    </li>
</ul>
<h4>Version 1.3.0</h4>
<ul>
    <li>Die Counter-Funktionen sind jetzt in einer Klasse zusammengefasst.<br/>
        *** Falls der Aufrufzähler im Seiten-Template angelegt ist, muss
        der Aufruf von <tt>counter_set</tt> entsprechend angepasst werden. ***</li>
    <li>Für die Formatierung der exemplarischen Ausgaben des Aufrufzählers
        ist eine Stylesheet-Datei eingefügt.</li>
</ul>
<h4>Version 1.2.0</h4>
<ul>
    <li>Die Installation des Moduls ist überarbeitet und systematisiert.</li>
</ul>
<h4>Version 1.1.0</h4>
<ul>
    <li>Der gesamte Source-Code ist jetzt auf UTF-8 umgestellt.</li>
    <li>Der Code ist mit 'error_reporting(E_ALL);' überprüft.</li>
</ul>
<h4>Version 1.0.0</h4>
<ul>
    <li>Dieses AddOn steht auch für Redaxo 4 zur Verfügung, allerdings nur für
        eine einsprachige Installation (Key: page_count)</li>
</ul>