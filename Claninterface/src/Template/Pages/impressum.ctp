<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>
<h1>Über diese Webseite</h1>
Diese Webseite bietet für einen Clan bzw. Clangruppe in World of Tanks statistische Auswertungen der Spieler-Leistung.<br />
Ziel der Statistik ist es, dem Spieler, ein besseres Verständnis über die eigenen Leistungen zu vermitteln als dies auf den großen Statistik-Seiten möglich ist.<br />
Auch werden der Clanleitung Auswertungen zur Einhaltung von Clanregeln angeboten.<br />


<h1>Rechtliches und Impressum</h1>

Es handelt sich bei diesem Webdienst laut § 5 TMG um eine private Webseite.<br />
Alle weiteren Angaben erfolgen auf freiwilliger Basis.<br />

<h2>Ansprechpartner</h2>
<b>Name: </b><?= Configure::read("Provider.name") ?><br />
<b>E-Mail: </b><?= Configure::read("Provider.mail") ?><br />
<b>Tel: </b><?= Configure::read("Provider.tel") ?><br />

<h2>Haftungsausschluss:</h2>

<h3>Haftung für Inhalte</h3>

Die Inhalte dieser Seiten wurden mit größter Sorgfalt erstellt.<br />
Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte wird keine Gewähr übernommen.<br />
Als Diensteanbieter bin ich gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach aktueller deutscher Gesetzgebung verantwortlich.<br />
Nach §§ 8 bis 10 TMG bin ich als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen<br />
oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen.<br />
Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt.<br />
Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich.<br />
Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden ich diese Inhalte umgehend entfernen.<br />

<h3>Haftung für Links</h3>

Das Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte ich keinen Einfluss habe.<br />
Deshalb wird für diese fremden Inhalte auch keine Gewähr übernommen.<br />
Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich.<br />
Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft.<br />
Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar.<br />
Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar.<br />
Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.<br />

<h3>Datenschutz Webseitennutzung</h3>
Die Nutzung unserer Webseite ist in der Regel ohne Angabe personenbezogener Daten möglich.<br />
<br />
Soweit auf unseren Seiten personenbezogene Daten (beispielsweise Name, Anschrift oder E-Mail-Adressen) erhoben werden, erfolgt dies, soweit möglich, stets auf freiwilliger Basis.<br />
Diese Daten werden ohne Ihre ausdrückliche Zustimmung nicht an Dritte weitergegeben.<br />
Wir weisen darauf hin, dass die Datenübertragung im Internet (z.B. bei der Kommunikation per E-Mail) Sicherheitslücken aufweisen kann. Ein lückenloser Schutz der Daten vor dem Zugriff durch Dritte ist nicht möglich.<br />
Der Nutzung von im Rahmen der Impressumspflicht veröffentlichten Kontaktdaten durch Dritte zur Übersendung von nicht ausdrücklich angeforderter Werbung und Informationsmaterialien wird hiermit ausdrücklich widersprochen. Die Betreiber der Seiten behalten sich ausdrücklich rechtliche Schritte im Falle der unverlangten Zusendung von Werbeinformationen, etwa durch Spam-Mails, vor.<br />

<h2>Funktionsbeschreibung:</h2>

<h3>Funktion der statistische Daten und Auswertungen</h3>
Dieser Webdienst verarbeitet Daten der Wargaming-Developer-API und hat Zugriff auf den Teamspeak-Server der Clangruppe und wertet bestimmte Ereignisse und Zustände aus.<br />
Daten werden nur erhoben soweit dies notwendig ist. um einzelne Dienste bereitzustellen.<br />
Daten werden falls notwendig aus beiden Quellen zusammengeführt.<br />
<br />
Nicht mehr benötigte Datenbestände werden regelmäßig gelöscht, dies ist ins besonders der Fall, wenn ein Spieler den Clan verlässt.<br />
Sie können der Nutzung der Wargaming-Developer-API wiedersprechen , bitte wenden Sie sich dazu an den Support bei Wargaming.<br />
Sie können der Auswertung des Teamspeak-Server  wiedersprechen, wenden Sie sich dazu an die obenstehende E-Mail.<br />
Mit dem Widerspruch gegen die Auswertung des Teamspeak-Server, erlischt auch das Nutzungsrecht des Teamspeak-Servers. <br />

<h3>Funktionen des Loginbereich</h3>
Der Angebotene Loginbereich bietet Funktionen zur Authentifizierung an der Applikation um erweiterte statistische Auswertungen zu Spielerwerten der Clangruppe einzusehen.
Der Umfang der Auswertung ergibt sich anhand der gewährten Berechtigung innerhalb der Applikation.<br />
Jegliche  Anmeldung erfolgt auf freiwilliger Basis.<br />

<h3>Neues Konto erstellen</h3>
Um ein neues Benutzerkonto auf dieser Webseite anzulegen werden folgende Information im Rahmen der Registrierung abgefragt.<br />
<ul>
    <li>Name, hierbei handelt es sich um ein Kontoname welcher auch ein Nickname sein kann</li>
    <li>E-Mail , zur Anmeldung und Kennwortrücksetzung</li>
    <li>Passwort, zur sicheren Authentifizierung</li>
</ul>

<h3> Login mit WarGaming-Konto (OpenID)</h3>
Die Option mit "Login mit WarGaming-Konto" leitet zur Authentifizierung zur Webseite des Unternehmens Wargaming Group Limited, dies ermöglicht die Nutzung dieses Dienstes ohne das  persönliche Daten (Name und E-Mail-Adresse) anzugeben.<br />
Bei Fragen zur Verarbeitung von Daten bei diesem Anbieter beachten Sie bitte die aktuellen Datenschutzrichtlinie und Nutzungsbedingungen des Anbieters.
Diese werden Ihnen bei jedem Login auf der Webseite des Anbieters angezeigt und finden sich dort unter<br />
<?= $this->Html->link("Rechtliche Dokumente", "https://legal.eu.wargaming.net/de/" )?> <small>(Stand 29.06.2021)</small><br />
Über dieses Loginmethode  werden dieser Webseite Informationen via OpenID bereitgestellt. Die bereitgestellten Informationen sind
bei einer erfolgreichen Anmeldung folgende:<br />
<ul>
    <li>Authentifizierungsstatus</li>
    <li>Zugriffstoken und Ablaufdatum (maximal 14 Tage)</li>
    <li>die ID des Accounts aus der Wargaming.net Datenbank</li>
    <li>Der Benutzername (Nickname) des Spielers</li>
</ul>
<h3> Passwort vergessen</h3>
Die Funktion "Passwort vergessen" sendet ein neues zufällig generierte Passwort an die angegebene E-Mailadresse, sofern dazu ein registriertes Konto existiert.
Dies funktioniert jedoch nur wenn nicht der Login nicht via "Login mit Wargaming-Konto" erfolgt.

<h3> Nutzerkonto entfernen</h3>
Nutzerkonten von Mitgliedern, welche nicht mehr Bestandteil einer der in dieser Applikation verwendeten Clan oder Clangruppe sind,
werden zyklisch gelöscht.<br />
<b>Soll ein Nutzerkonto unabhängig von diesem Merkmal aus dieser Applikation entfernt werden, wenden Sie sich bitte an die oben stehende E-Mail Adresse.</b><br />
<br />
<br />
<br />
<b>Stand 29.06.2021</b>
<hr />
<center><b><i>Diese Seite ist ein kostenfreier von einem Spieler betriebener Service für World of Tanks.
            Diese Webseite ist keine offizielle Webseite der Wargaming Group Limited, diese findet sich unter Wargaming.net .
            World of Tanks ist eine Marke der Wargaming Group Limited.</i></b></center>



