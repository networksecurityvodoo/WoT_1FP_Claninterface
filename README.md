#WoT Claninterface by LFS96

Das WoT-Claninterface wurde für die 1FP-Clangruppe entwickelt.
Die meisten Anpassungen wurden auf diese Clangruppe optimiert.

Der aktuelle Stand ist "work in progress", an vielen Schrauben wird immer noch gedreht.
Funktionen zum Verwalten und zur effektiven Verarbeitung von DSGVO Anfragen sind noch nicht gegeben.

Git-Repo wurde zum Release der V1.0 zurückgesetzt, zu viele private Informationen.
Es war einfacher und schneller das Git neu aufzubauen als es zu bereinigen.

**Dies ist ein kleines privat Projekt ohne Anspruch auf Perfektion. 
Falls es Fragen, Vorschläge oder Probleme gibt einfach kurz melden.**

_PS: Falls ich mal wieder die SQL-Dateien nicht erneuert habe, bitte melden._

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

### Vorraussetzung
Diese Voraussetzungen sind die Einstellungen meines Entwicklungssystems

 - PHP 7.3+
 - MariaDB 10.4.4
 - Apache 2.4.46

## Config
siehe `Claninterface/config` dort gibt es Example Dateien, diese einfach anpassen.
Der Datenbank aufbau ist als `CakePHP Migration` verfügbar, zusätzlich gibt es ein paar Dateien im `sql/` Ordner.
Einige Aufrufe müssen regelmäßig durchgeführt werden, ich habe ein beispiel für die Einrichtug in crontab unter `cron_example` abgelegt.

## Referenzen

- WG-API https://developers.wargaming.net/documentation/guide/getting-started/

- PHP WG-API
  https://github.com/artur-stepien/wargaming-papi/blob/master/api.php

- WN8 Berechnung
  http://forum.worldoftanks.eu/index.php?/topic/547149-wn8-formula-detailed-breakdown-stat-nerds-should-drop-by/

- WN8 Erwarte Werte (XVM)
  https://modxvm.com/en/wn8-expected-values/

- Teamspeak 3 - Server Framework https://github.com/planetteamspeak/ts3phpframework



# Based on CakePHP 3.9+

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)
[![Total Downloads](https://img.shields.io/packagist/dt/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

A skeleton for creating applications with [CakePHP](https://cakephp.org) 3.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist "cakephp/app:^3.8"
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist "cakephp/app:^3.8" myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit `config/app.php` and setup the `'Datasources'` and any other
configuration relevant for your application.

## Layout

The app skeleton uses a subset of [Foundation](http://foundation.zurb.com/) (v5) CSS
framework by default. You can, however, replace it with any other library or
custom styles.
