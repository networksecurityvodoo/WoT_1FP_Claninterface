# WoT Claninterface by LFS96

Das WoT-Claninterface wurde für die 1FP-Clangruppe entwickelt.
Die meisten Anpassungen wurden auf diese Clangruppe optimiert.

Der aktuelle Stand ist "work in progress", an vielen Schrauben wird immer noch gedreht.
Funktionen zum Verwalten und zur effektiven Verarbeitung von DSGVO Anfragen sind noch nicht gegeben.

Git-Repo wurde zum Release der V1.0 zurückgesetzt, zu viele private Informationen.
Es war einfacher und schneller das Git neu aufzubauen als es zu bereinigen.

**Dies ist ein kleines privat Projekt ohne Anspruch auf Perfektion. 
Falls es Fragen, Vorschläge oder Probleme gibt einfach kurz melden.**

<!-- _PS: Falls ich mal wieder die SQL-Dateien nicht erneuert habe, bitte melden._ -->

## Funktionen
- Teamspeak 3
  - Aufzeichnen von Verstößen (Spieler Ingame aber nicht im TS3-Server)
  - Live übersicht
  - Admin (Kicken, Tages-Ban)
  - Abfragen des eigenen Ranges (nach Tagen in Clangruppe Staffel nach 1FP-Regeln)
- Veranstaltungen
  - Anlegen von einmaligen und wöchentlichen Veranstaltungen
  - Erfassung der teilnehmenden Spieler
- Abmeldungen/Auszeiten von Spielern verwalten
- Statistiken
  - Statistiken für jeden Spieler
  - Tages Statistiken für jeden Panzer und Spieler nach Gefechtstyp
  - Bestenlisten nach Panzer und Gefechtstyp
- Account/Login-Area
  - Login via Wargaming OpenID
  - Konto erstellen via E-Mail und Passwort
  - Passwort ändern
  - Neues Passwort per E-Mail erhalten
  - Rechtesystem via Ingame-Rang (+ Admin-Flag)


## Einrichtung

### Abhängikeiten:
Diese Voraussetzungen sind die Einstellungen meines Entwicklungssystems


![](https://img.shields.io/badge/PHP-7.3+-grey?logo=php)

![](https://img.shields.io/badge/CakePHP-3.9-grey?logo=cakephp)

![](https://img.shields.io/badge/Apache-2.4.46-grey?logo=apache)

![](https://img.shields.io/badge/MariaDB-10.4.4.-grey?logo=mariadb)


## Config
siehe `Claninterface/config` dort gibt es Example Dateien, diese einfach anpassen.
Der Datenbank aufbau ist als `CakePHP Migration` verfügbar, zusätzlich gibt es ein paar Dateien im `sql/` Ordner.
Einige Aufrufe müssen regelmäßig durchgeführt werden, ich habe ein beispiel für die Einrichtug in crontab unter `cron_example` abgelegt.

## Referenzen

- WG-API https://developers.wargaming.net/documentation/guide/getting-started/
- PHP WG-API https://github.com/artur-stepien/wargaming-papi
- WN8 Berechnung http://forum.worldoftanks.eu/index.php?/topic/547149-wn8-formula-detailed-breakdown-stat-nerds-should-drop-by/
- WN8 Erwarte Werte (XVM) https://modxvm.com/en/wn8-expected-values/
- Teamspeak 3 - Server Framework https://github.com/planetteamspeak/ts3phpframework



