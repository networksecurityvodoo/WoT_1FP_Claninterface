# Developer Documentation — WoT 1FP Claninterface

> **Repository:** [networksecurityvodoo/WoT_1FP_Claninterface](https://github.com/networksecurityvodoo/WoT_1FP_Claninterface)  
> **Version:** 1.1 (CakePHP 4.3 Branch)  
> **Stand der Analyse:** Juni 2026  
> **Lizenz:** MIT

---

## Inhaltsverzeichnis

1. [Projektübersicht](#1-projektübersicht)
2. [Tech-Stack & Abhängigkeiten](#2-tech-stack--abhängigkeiten)
3. [Verzeichnisstruktur](#3-verzeichnisstruktur)
4. [Architektur & Designentscheidungen](#4-architektur--designentscheidungen)
5. [Datenbankmodell](#5-datenbankmodell)
6. [Berechtigungssystem](#6-berechtigungssystem)
7. [Externe Integrationen](#7-externe-integrationen)
8. [CLI-Commands & Cron-Jobs](#8-cli-commands--cron-jobs)
9. [Controller-Referenz](#9-controller-referenz)
10. [Logic-Layer: Helpers & Configs](#10-logic-layer-helpers--configs)
11. [Sicherheitsanalyse](#11-sicherheitsanalyse)
12. [Einrichtung & Konfiguration](#12-einrichtung--konfiguration)
13. [Bekannte Einschränkungen & Offene Punkte](#13-bekannte-einschränkungen--offene-punkte)

---

## 1. Projektübersicht

Das **WoT Claninterface** ist eine PHP-Webanwendung auf Basis von CakePHP, die für die Verwaltung von World-of-Tanks-Clangruppen (konkret: 1FP) entwickelt wurde. Sie verbindet drei externe Systeme miteinander:

| System | Funktion |
|---|---|
| Wargaming-API (WG-API) | Spieler-/Clan-/Statistikdaten aus World of Tanks |
| TeamSpeak 3 ServerQuery | Anwesenheitskontrolle, Kick/Ban-Aktionen |
| E-Mail (SMTP) | Passwort-Reset-Workflow |

**Kernfunktionen:**
- Spieler- und Clan-Verwaltung inkl. automatischer Synchronisation mit der WG-API
- Statistikerfassung und WN8-Berechnung pro Spieler und Panzer
- TeamSpeak-Anwesenheits-Monitoring und Protokollierung von Regelverstößen
- Veranstaltungs-/Meeting-Verwaltung mit automatischer Teilnehmererfassung
- Abmeldungs-/Inaktivitätsverwaltung für Clanmitglieder
- Authentifizierung über E-Mail/Passwort **oder** Wargaming OpenID

---

## 2. Tech-Stack & Abhängigkeiten

### Runtime-Anforderungen

| Komponente | Version |
|---|---|
| PHP | >= 7.3 |
| CakePHP | 3.9.x |
| MariaDB / MySQL | >= 10.4 |
| Apache | 2.4.x (mit mod_rewrite) |

### Composer-Abhängigkeiten (Produktion)

| Paket | Zweck |
|---|---|
| `cakephp/cakephp:3.9.*` | MVC-Framework |
| `cakephp/migrations:^2.0` | Datenbank-Migrations |
| `artur-stepien/wargaming-papi:^1.3` | WG-API-Client |
| `planetteamspeak/ts3-php-framework:^1.1` | TeamSpeak ServerQuery |
| `friendsofcake/bootstrap-ui:2.x-dev` | Bootstrap 4 Integration für CakePHP |
| `mobiledetect/mobiledetectlib:2.*` | Mobile-Detection |

### Frontend-Bibliotheken (lokal eingebettet)

- Bootstrap 4 (SCSS-Quellen in `webroot/css/bootstrap4/`)
- Font Awesome 5 (Icons)
- Bootstrap Icons
- jQuery 3.5.1 + jQuery UI
- Popper.js

> **Hinweis:** Alle Frontend-Assets sind statisch im Repository abgelegt — kein Build-Prozess (Webpack, npm o.ä.) vorhanden.

---

## 3. Verzeichnisstruktur

```
WoT_1FP_Claninterface/
├── Claninterface/                  # CakePHP-Applikationswurzel
│   ├── bin/                        # cake CLI
│   ├── config/
│   │   ├── app.php                 # Haupt-Konfiguration (DB, Cache, Session)
│   │   ├── app_local.example.php   # Lokale Überschreibungen (nicht einchecken!)
│   │   ├── external_api.example.php# API-Zugangsdaten (Template)
│   │   ├── routes.php              # URL-Routing + CSRF-Middleware
│   │   ├── bootstrap.php           # App-Bootstrap
│   │   └── Migrations/             # Phinx-Migrationsdateien
│   ├── src/
│   │   ├── Application.php         # Middleware-Stack, Plugin-Registrierung
│   │   ├── Controller/             # HTTP-Controller (CRUD + Custom Actions)
│   │   ├── Model/
│   │   │   ├── Entity/             # ORM-Entitäten (Zugriff auf Felder)
│   │   │   └── Table/              # ORM-Tables (Validation, Associations)
│   │   ├── Logic/
│   │   │   ├── Config/             # Konfigurations-Wrapper (WgApi, TS, Statistiken)
│   │   │   └── Helper/             # Business-Logik (WN8, WarGaming, TeamSpeak, …)
│   │   ├── Command/                # CakePHP CLI-Commands für Cron
│   │   ├── Template/               # View-Templates (.ctp)
│   │   └── View/                   # View-Klassen (App, Ajax)
│   ├── tests/                      # PHPUnit-Tests + Fixtures
│   └── webroot/                    # Öffentliches Verzeichnis (DocumentRoot)
│       ├── index.php               # Einstiegspunkt
│       ├── css/, js/, font/, img/  # Frontend-Assets
│       └── .htaccess               # mod_rewrite-Regeln
├── sql/                            # Ergänzende SQL-Dateien (Ränge, Sessions, Charset)
├── cron_example                    # Crontab-Vorlage
└── README.md
```

---

## 4. Architektur & Designentscheidungen

### 4.1 MVC-Muster (CakePHP 3)

Das Projekt folgt strikt dem CakePHP-MVC-Muster:

```
HTTP-Request
    → Routing (routes.php + DashedRoute)
    → Middleware (CSRF, Error, Asset, Routing)
    → Controller (Authorization via isAuthorized())
    → Model/Table (ORM, Validation, Business-Rules)
    → Template (.ctp) / JSON (Ajax)
    → HTTP-Response
```

### 4.2 Erweiterter Logic-Layer (`src/Logic/`)

Abweichend von reinem MVC gibt es einen zusätzlichen `Logic/`-Layer:

- **`Logic/Config/`** — Singleton-ähnliche Konfigurations-Wrapper, die `Configure::read()` kapseln und fertige Service-Objekte zurückgeben (z.B. `WgApi::getWG_API()`)
- **`Logic/Helper/`** — Stateless Service-Klassen mit Geschäftslogik, die nicht in Controller oder Model gehören (WN8-Berechnung, WG-API-Aufrufe, TS-Queries)

**Designmotivation:** Trennung von HTTP-Handling (Controller) und fachlicher Logik (Helper). Erlaubt Wiederverwendung in CLI-Commands ohne HTTP-Kontext.

### 4.3 Berechtigungs-Architektur

Statt CakePHPs eingebautem ACL-Plugin wird ein **eigenes numerisches Berechtigungslevel** verwendet (`RightsHelper`), das bei jedem Request in `AppController::initialize()` berechnet wird:

```
Level -1  → nicht eingeloggt / kein User
Level  0  → eingeloggter User ohne Token
Level  3  → Clanmitglied (Token vorhanden)
Level  5  → Spezifischer Rang (rank_id = 4)
Level  8  → Kommandant / höherer Rang (rank_id <= 2)
Level 10  → Admin (admin-Flag in users-Tabelle)
```

### 4.4 Token-System (Wargaming OpenID)

Das Berechtigungssystem nutzt **WG-Access-Tokens** als Nachweis der Clanmitgliedschaft. Ein Token:
- wird nach WG-OpenID-Login oder manuellem Hinzufügen gespeichert
- hat ein `expires`-Datum (von WG vorgegeben, max. ~2 Wochen)
- verbindet einen lokalen `User` mit einem `Player` (WG-Account-ID)

Dieses Design erlaubt es, dass sich Spieler **ohne E-Mail-Konto** ausschließlich via Wargaming-OAuth anmelden können.

### 4.5 Cron-basierte Datenpflege

Zeitgesteuerte Aufgaben laufen als CakePHP CLI-Commands:

```
Teamspeak-Prüfung (alle 3 min)  → TS-Verstoßprotokoll aktualisieren
Import (3×/Tag)                 → Spieler/Clan/Tank-Daten von WG-API
Stats (1×/Tag, 3 Uhr)          → Tages-Statistiken importieren
Meeting (alle 6 min)            → Laufende Veranstaltungen + Teilnehmer erfassen
CleanData (1×/Woche)            → Ehemalige Spieler nach N Tagen löschen
Notice (stündlich abends)       → Benachrichtigungen versenden
```

### 4.6 Designentscheidung: Kein REST-API

Das Interface ist als klassische Server-rendered Web-App konzipiert. Es gibt keine JSON-API für externe Konsumenten — alle Daten werden ausschließlich über `.ctp`-Templates ausgegeben. Ajax-Requests werden über eine dedizierte `AjaxView`-Klasse bedient.

---

## 5. Datenbankmodell

### Tabellenübersicht (aus Initial-Migration)

| Tabelle | Beschreibung |
|---|---|
| `users` | Lokale Benutzerkonten (E-Mail + Passwort, Admin-Flag) |
| `players` | WoT-Spieler (WG Account-ID als Primary Key) |
| `clans` | WoT-Clangruppen |
| `ranks` | Clan-Ränge (commander, executive_officer, …) |
| `tokens` | WG-Access-Tokens; verbinden User ↔ Player |
| `meetings` | Veranstaltungen/Events |
| `meetingparticipants` | Teilnehmer an Meetings (automatisch erfasst) |
| `meetingregistrations` | Manuelle Anmeldungen für Meetings |
| `inactives` | Abmeldungen/Auszeiten von Spielern |
| `statistics` | Tagessstatistiken je Spieler + Panzer + Gefechtstyp |
| `tanks` | Panzerliste inkl. WN8-Erwartungswerte |
| `tanktypes` | Panzertypen (heavyTank, mediumTank, …) |
| `teamspeaks` | TeamSpeak-Anwesenheitsprotokoll (Verstöße) |
| `sessions` | Datenbank-Sessions (CakePHP Session-Handler) |
| `raws` | Rohdaten-Speicher (generisch, Typ über `type`-Feld) |

### Wichtige Beziehungen

```
users       1 — n  tokens
players     1 — n  tokens
players     n — 1  clans
players     n — 1  ranks
players     1 — n  statistics
players     1 — n  teamspeaks
players     1 — n  inactives
statistics  n — 1  tanks
tanks       n — 1  tanktypes
meetings    1 — n  meetingparticipants
meetings    1 — n  meetingregistrations
meetings    n — 1  clans
```

### Besonderheiten

- `players.id` ist **keine Auto-Increment-ID** — es ist die WG-Account-ID (externe ID).
- `statistics` hat einen **zusammengesetzten Primary Key** (`player_id`, `tank_id`, `date`, `battletype`) — kein separates `id`-Feld.
- `teamspeaks.end = '1970-01-01'` fungiert als **Sentinel-Wert** für "noch offen / kein Ende gesetzt" (statt NULL).

---

## 6. Berechtigungssystem

### Implementierung

`RightsHelper::findPermissionLevel(int $user_id)` wird bei **jedem Request** in `AppController::initialize()` ausgeführt und führt bis zu **4 separate Datenbankabfragen** aus:

```php
// Pseudocode der Logik
if (admin-Flag gesetzt)              → return 10
if (Token mit rank_id <= 2)          → return 8   // Kommando
if (Token mit rank_id = 4)           → return 5   // Spezifischer Rang
if (irgendein Token vorhanden)       → return 3   // Normales Mitglied
                                     → return 0   // Kein Token
```

### Controller-seitige Prüfung

Jeder Controller überschreibt `isAuthorized($user)`. Standard in `AppController`:

```php
public function isAuthorized($user) {
    if ($this->permissionLevel >= 10) return true;
    return false;
}
```

Controller-spezifische Überschreibungen erlauben feingranulare Kontrolle (z.B. eigenes Profil ansehen ab Level 0, TS-Kick/Ban nur ab Level 10).

### Öffentliche Routen

Folgende Actions sind via `$this->Auth->allow()` ohne Login zugänglich:
- `Users::login`, `Users::logout`, `Users::add`, `Users::unlock`
- `Tokens::login` (WG-OAuth-Callback)
- `DebugController::test` (**⚠️ kritisch — siehe Sicherheitsanalyse**)

---

## 7. Externe Integrationen

### 7.1 Wargaming-API

**Konfiguration:** `config/external_api.php` (nicht im Repo — aus `external_api.example.php` erstellen)

```php
"Wargaming" => [
    "authkey" => '<WG_DEVELOPER_API_KEY>',
    "expectedValues" => 'https://static.modxvm.com/wn8-data-exp/json/wn8exp.json',
    "lang" => "de",
    "server" => "api.worldoftanks.eu"
]
```

**Genutzte WG-API-Endpunkte:**

| Endpunkt | Verwendung |
|---|---|
| `wot/account/list` | Spieler nach Nickname suchen |
| `wot/account/info` | Spielerdetails (letztes Gefecht, Schlachten) |
| `wot/clans/list` | Clan per Tag suchen |
| `wot/clans/info` | Clandetails + Mitgliederliste |
| `wot/clans/memberhistory` | Clan-Beitrittsverlauf eines Spielers |
| `wgn/clans/info` | Online-Mitglieder (benötigt Access-Token) |
| `wot/tanks/stats` | Panzerspezifische Statistiken |

> **Wichtig:** `WgApi::getWG_API()` setzt `$api->setSSLVerification(false)` — SSL-Verifikation ist **deaktiviert** (⚠️ Sicherheitsproblem, siehe Abschnitt 11).

### 7.2 TeamSpeak 3 ServerQuery

**Konfiguration:**
```php
'TeamspeakQueryConnection' => [
    'host' => '127.0.0.1',
    'port' => 10011,    // Standard ServerQuery-Port
    'uid'  => '1',      // Virtual Server ID
],
'TeamspeakQueryLogin' => [
    'user'      => '<TS_QUERY_USER>',
    'pass'      => '<TS_QUERY_PASSWORD>',
    'loginName' => 'WebInterface by LFS96'
],
```

**Genutzte Operationen:**

| Funktion | Methode |
|---|---|
| Client-Liste abrufen | `clientList()` |
| Spieler nach Name kicken | `clientGetByName()->kick()` |
| Spieler nach UID kicken | `clientGetByUid()->kick()` |
| Spieler bannen (24h) | `->ban($seconds, $msg)` |
| Nachricht an Spieler | `->poke()`, `->message()` |
| Nachricht an Servergruppe | `serverGroupGetById()->clientList()` |
| Channel-Liste | `channelList()` |

**Fehlerbehandlung:** Verbindungsfehler im Konstruktor von `TeamSpeakQueryHelper` werden mit `try/catch` abgefangen. Bei Fehlschlag wird `$this->virtualServer = false` gesetzt; alle Methoden prüfen diesen Wert.

### 7.3 WN8-Berechnung

Die WN8-Metrik (Kampfeffektivität) wird nach der offiziellen Formel berechnet ([Referenz: worldoftanks.eu Forum](http://forum.worldoftanks.eu/index.php?/topic/547149-wn8-formula-detailed-breakdown-stat-nerds-should-drop-by/)):

**Eingaben pro Panzer:** Schaden, Aufklärung, Abschüsse, Verteidigung, Siege (jeweils normiert auf Anzahl Schlachten)

**Erwartungswerte** werden von XVM (`modxvm.com/wn8-data-exp`) bezogen und in der `tanks`-Tabelle gespeichert (`expDamage`, `expSpot`, `expFrag`, `expDef`, `expWinRate`).

---

## 8. CLI-Commands & Cron-Jobs

### Verfügbare Commands

| Command | Klasse | Funktion |
|---|---|---|
| `cake Teamspeak` | `TeamspeakCommand` | TS-Regeln prüfen, Verstöße protokollieren |
| `cake Import` | `ImportCommand` | Spieler + Panzer + Clan-Daten von WG-API synchronisieren |
| `cake Stats` | `StatsCommand` | Tages-Statistiken für alle Clan-Spieler importieren |
| `cake Meeting` | `MeetingCommand` | Laufende Meetings detektieren, Folgemeeting anlegen, Teilnehmer erfassen |
| `cake CleanData` | `CleanDataCommand` | Ehemalige Spieler nach konfigurierten Tagen löschen |
| `cake Notice` | `NoticeCommand` | Benachrichtigungen (TS-Nachrichten) versenden |

### Empfohlene Crontab

```cron
# TS-Prüfung alle 3 Minuten
*/3 * * * * /Claninterface/bin/cake Teamspeak

# Daten-Import 3× täglich
0 3,15,23 * * * /Claninterface/bin/cake Import

# Abend-Benachrichtigungen
15 16,17,18,19,20,21,22 * * * /Claninterface/bin/cake Notice

# Tages-Statistiken (3 Uhr)
0 3 * * * /Claninterface/bin/cake Stats

# Datenbereinigung (wöchentlich)
0 1 */7 * * /Claninterface/bin/cake CleanData

# Meeting-Erfassung alle 6 Minuten
*/6 * * * * /Claninterface/bin/cake Meeting
```

> Pfad `/Claninterface/` muss auf das tatsächliche Installationsverzeichnis angepasst werden.

---

## 9. Controller-Referenz

### AppController (Basis)

Alle Controller erben von `AppController`. Dieser lädt bei jedem Request:
- `RequestHandler` Component
- `Flash` Component
- `Auth` Component (Form-Authentifizierung, Email als Username-Feld)
- `RightsHelper` → setzt `$this->permissionLevel` und View-Variable `permissionLevel`

### Controller-Übersicht

| Controller | Route | Besonderheiten |
|---|---|---|
| `UsersController` | `/users/*` | Login, Logout, Registrierung, Passwort-Reset, Dashboard |
| `TokensController` | `/tokens/*` | WG-OAuth-Callback (`receive`, `login`), Token-CRUD |
| `TeamspeaksController` | `/teamspeaks/*` | TS-Live-Ansicht, Kick/Ban, Verstoßprotokoll |
| `ClansController` | `/clans/*` | Clan-CRUD + WG-API-Lookup |
| `PlayersController` | `/players/*` | Spieler-CRUD, Statistik-Ansichten, TS-Rang |
| `MeetingsController` | `/meetings/*` | Veranstaltungs-CRUD, Event-Liste |
| `MeetingparticipantsController` | `/meetingparticipants/*` | Teilnehmer-CRUD |
| `MeetingregistrationsController` | `/meetingregistrations/*` | Anmeldungs-CRUD |
| `InactivesController` | `/inactives/*` | Abmeldungs-CRUD, Startseite (Redirect-Ziel `/`) |
| `RanksController` | `/ranks/*` | Rang-Verwaltung |
| `TanksController` | `/tanks/*` | Panzer-CRUD |
| `TanktypesController` | `/tanktypes/*` | Panzertypen-CRUD |
| `PagesController` | `/pages/*` | Statische Seiten (Impressum, Home) |
| `DebugController` | `/debug/*` | **Nur Entwicklung** — ⚠️ in Produktion entfernen |
| `ErrorController` | — | Fehlerseiten (400, 500) |

### Token-Endpunkte im Detail

**`GET /tokens/login?status=ok&account_id=…&access_token=…&expires_at=…&nickname=…`**  
WG-OpenID-Callback: Legt automatisch einen lokalen User an (falls nicht vorhanden) und loggt ihn ein.

**`GET /tokens/receive?…`** (authentifiziert)  
Verbindet einen WG-Account-Token mit einem bestehenden lokalen User-Account.

---

## 10. Logic-Layer: Helpers & Configs

### Config-Klassen (`src/Logic/Config/`)

| Klasse | Funktion |
|---|---|
| `WgApi` | Fabrikmethode `getWG_API()` → konfiguriertes `Wargaming\Api`-Objekt |
| `TeamSpeakQueryConfig` | Fabrikmethode → konfigurierten TS3-VirtualServer + Login-Name |
| `StatisticsConfigHelper` | Konstanten: Feldliste für WG-API-Statistik-Requests, Gefechtstypen |
| `TankTypes` | Mapping WG-interne Typnamen → Anzeigebegriffe |

### Helper-Klassen (`src/Logic/Helper/`)

| Klasse | Methoden (Auswahl) | Beschreibung |
|---|---|---|
| `WarGamingHelper` | `searchPlayer()`, `updateClanMembers()`, `getOnlinePlayers()`, `getPlayerByTsNick()`, `getOldDays()` | Zentrale WG-API-Integration, Clan-Synchronisation |
| `TeamSpeakQueryHelper` | `getClientlist()`, `kickPlayerByUID()`, `banPlayerByName()`, `getOnlinePlayersInfo()`, `msgServerGroup()` | TS3-ServerQuery-Wrapper |
| `WN8Helper` | `calcWN8()`, `getPlayerWN8()`, `WnColor()`, `SiegColor()` | WN8-Berechnung + Farbkodierung |
| `PlayerDataHelper` | `importPlayerStatistic()`, `cleanUpPlayer()` | Spielerstatistiken importieren, alte Spieler bereinigen |
| `MeetingsHelper` | `createFollowMeeting()`, `findParticipant()` | Wiederkehrende Meetings anlegen, Teilnehmer via TS erfassen |
| `ClanRuleHelper` | `checkTeamSpeak()` | Abgleich WoT-Online ↔ TS3-Online, Verstoßprotokoll |
| `RightsHelper` | `findPermissionLevel()`, `getPermissionLevel()` | Berechtigungslevel berechnen |
| `RanksHelper` | `string2rank()` | WG-Rang-String → lokale `rank_id` |
| `StringHelper` | `generateRandomString()`, `str_contains()` | Hilfsfunktionen: Zufallsstring, Substring-Suche |
| `TimeHelper` | (Zeitformatierung) | Datumsformatierungs-Utilities |
| `TankDataHelper` | `getTankList()`, `importTank()` | Panzerliste von WG-API importieren |

---

## 11. Sicherheitsanalyse

> Bewertungsschema: 🔴 Critical · 🟡 Warning · 🔵 Suggestion

---

### 🔴 CRITICAL — DebugController öffentlich zugänglich

**Datei:** `src/Controller/DebugController.php`  
**Problem:** Die Action `debug/test` ist via `$this->Auth->allow(['test'])` ohne Authentifizierung zugänglich. Sie gibt WG-API-Suchergebnisse mit `dump()` direkt im Response aus.

```php
// DebugController.php
public function initialize() {
    parent::initialize();
    $this->Auth->allow(['test']); // ← kein Passwortschutz
}
public function test(){
    $wg = new WarGamingHelper();
    $acc = $wg->searchPlayer("LFS96"); // API-Key wird genutzt!
    dump($acc);
}
```

**Risiko:** Jeder externe Angreifer kann API-Calls auf Kosten des WG-API-Keys auslösen und Debug-Ausgaben einsehen.  
**Behebung:** Controller in Produktion vollständig entfernen oder auf `permissionLevel >= 10` einschränken.

---

### 🔴 CRITICAL — SSL-Verifikation der WG-API deaktiviert

**Datei:** `src/Logic/Config/WgApi.php`

```php
$api->setSSLVerification(false); // ← deaktiviert TLS-Zertifikatsprüfung
```

**Risiko:** Anfällig für Man-in-the-Middle-Angriffe gegen die WG-API-Kommunikation. API-Keys und Spieler-Access-Tokens können abgefangen werden.  
**Behebung:** `setSSLVerification(true)` setzen. Falls serverseitige CA-Probleme bestehen, das Server-CA-Bundle korrekt konfigurieren.

---

### 🔴 CRITICAL — Passwort-Reset ohne Rate-Limiting

**Datei:** `src/Controller/UsersController.php` → `unlock()`

```php
// Kein Rate-Limiting, kein CAPTCHA
// Bei Eingabe einer E-Mail wird sofort ein neues Passwort generiert und gesendet
$newPassword = StringHelper::generateRandomString();
$account->password = $newPassword;
$this->Users->save($account);
```

**Risiko:** Brute-Force-Enumeration gültiger E-Mail-Adressen, DoS durch massenhaften E-Mail-Versand, Kontomissbrauch durch Passwort-Reset ohne Bestätigungstoken.  
**Behebung:** Token-basierter Reset-Flow mit zeitlich begrenztem Link; Rate-Limiting (z.B. max. 3 Resets/Stunde/IP).

---

### 🔴 CRITICAL — Minimale Passwort-Länge: 3 Zeichen

**Datei:** `src/Model/Table/UsersTable.php`

```php
'isSecurePassword' => [
    'rule' => function ($value, $context) {
        return strlen($value) >= 3; // ← viel zu niedrig
    },
    'message' => __("Ihr Passwort sollte mindestens 3 Zeichen haben."),
],
```

**Risiko:** Bruteforce-Angriffe trivial möglich. Keine Komplexitätsanforderungen.  
**Behebung:** Mindestlänge auf 12+ Zeichen erhöhen, optional Komplexitätsprüfung (Groß/Klein, Zahl, Sonderzeichen) oder Passwortstärke-Bibliothek einsetzen.

---

### 🔴 CRITICAL — WG-OAuth-Callback ohne vollständige Validierung

**Datei:** `src/Controller/TokensController.php` → `login()`, `receive()`

```php
$data = $this->request->getParam('?');
if($data["status"] != "error"){
    // Direkt $data["account_id"] und $data["access_token"] verwenden
}
```

**Risiko:** GET-Parameter kommen direkt vom Client. Es gibt keine Signaturprüfung des OAuth-Callbacks. Ein Angreifer kann beliebige `account_id`- und `access_token`-Werte übergeben.  
**Behebung:** WG-OpenID-Response via `openid_sig` / `openid.signed` kryptographisch verifizieren (Standard OpenID 2.0 Verification).

---

### 🟡 WARNING — Rohe SQL-Abfrage in `getPlayerByTsNick()`

**Datei:** `src/Logic/Helper/WarGamingHelper.php`

```php
public function getPlayerByTsNick($nick){
    $connection = ConnectionManager::get('default');
    $res = $connection->execute(
        "SELECT id FROM players WHERE locate(nick,?) LIMIT 1",
        [$nick]
    )->fetchAll('assoc');
```

**Bewertung:** Die Query ist parameterisiert (`[$nick]`) — SQL-Injection ist nicht direkt möglich. Jedoch: `locate(nick, ?)` durchsucht den gesamten Eingabestring auf den nick-Feldinhalt (umgekehrte Logik!), was zu falschen Matches führen kann. Außerdem kein Index-Einsatz möglich → Performance-Problem bei großen Tabellen.  
**Behebung:** ORM-Methode verwenden: `$PlayersTable->find()->where(['nick LIKE' => '%' . $nick . '%'])`. Index auf `nick` prüfen.

---

### 🟡 WARNING — `$_SERVER['PHP_AUTH_USER']` in TeamSpeak-Kick-Nachrichten

**Datei:** `src/Logic/Helper/TeamSpeakQueryHelper.php`

```php
public function kickPlayerByName($name) {
    $this->virtualServer->clientGetByName($name)->kick(
        TeamSpeak3::KICK_SERVER,
        "kicked by Clansystem, user: " . $_SERVER['PHP_AUTH_USER'] // ← direkte Servervar
    );
}
```

**Problem:** `$_SERVER['PHP_AUTH_USER']` ist leer, wenn keine HTTP-Basic-Auth verwendet wird (was bei dieser App nicht der Fall ist). Kein strukturierter Audit-Log.  
**Behebung:** Auth-User aus CakePHP-Session verwenden, strukturierten Log-Eintrag anlegen.

---

### 🟡 WARNING — Debug-`echo`-Statements in Produktionscode

**Datei:** `src/Logic/Helper/WN8Helper.php`

```php
public static function getPlayerWN8($player_id, $battletype, $date = null) {
    // ...
    echo "<table>";
    echo $stats->count();
    foreach ($stats as $stat){
        echo "<tr><td>".$stat->Tanks["name"]."</td>...";
    }
    echo "</table>";
}
```

**Problem:** HTML wird direkt per `echo` in die Ausgabe geschrieben, statt über das Template-System. Durchbricht das MVC-Muster und macht Testing unmöglich. Auch XSS-Risiko wenn `$stat->Tanks["name"]` ungeprüft ausgegeben wird.  
**Behebung:** Daten als Array zurückgeben, Rendering dem Template überlassen. `htmlspecialchars()` für alle Ausgaben.

---

### 🟡 WARNING — Sentinel-Wert `1970-01-01` statt NULL

**Datei:** `src/Logic/Helper/ClanRuleHelper.php` und `TeamspeaksController.php`

```php
->where(["end <" => "1970-01-02"])   // "noch offen"
->where(["end >=" => "1970-01-02"])  // "bereits geschlossen"
```

**Problem:** Magischer Datumsstring als Ersatz für NULL. Fehleranfällig, schwer wartbar, Zeitzonenprobleme möglich.  
**Behebung:** Nullable `end`-Feld in der DB (NULL = offen), Abfrage via `IS NULL` / `IS NOT NULL`.

---

### 🟡 WARNING — Kein CSRF-Schutz für API-Callbacks

**Datei:** `config/routes.php`

Die CSRF-Middleware wird zwar global aktiviert (`$routes->applyMiddleware('csrf')`), aber `Tokens::login` und `Tokens::receive` sind via `Auth->allow()` öffentlich. WG-Callbacks kommen per `GET` und können daher keine CSRF-Tokens mitführen — das ist per se in Ordnung, sollte aber explizit dokumentiert sein.

---

### 🟡 WARNING — Fehlende `Security`-Component

**Datei:** `src/Controller/AppController.php`

```php
// Enable the following component for recommended CakePHP security settings.
// see https://book.cakephp.org/3/en/controllers/components/security.html
//$this->loadComponent('Security'); // ← auskommentiert
```

CakePHPs `SecurityComponent` bietet zusätzlichen HTTP-Method-Schutz und Form-Tampering-Erkennung.  
**Empfehlung:** Aktivieren und testen, ob bestehende Formulare kompatibel sind.

---

### 🟡 WARNING — Erste Registrierung wird automatisch Admin

**Datei:** `src/Controller/UsersController.php`

```php
$regUsers = $this->Users->find("all")->count();
if ($regUsers == 0) {
    $user->admin = 1; // erster User = Admin
}
```

**Problem:** Race Condition bei gleichzeitiger Registrierung (unwahrscheinlich, aber möglich). Kein expliziter Setup-Schritt — in Produktionsumgebungen riskant.  
**Empfehlung:** Setup über CLI-Command oder Umgebungsvariable absichern.

---

### 🔵 SUGGESTION — Typo im Methodennamen

**Datei:** `src/Logic/Helper/RightsHelper.php`

```php
public function findPermissionLefel($user) { ... } // "Lefel" statt "Level"
```

Nicht sicherheitsrelevant, aber schlechte Lesbarkeit. Bei einem Refactoring korrigieren.

---

### 🔵 SUGGESTION — CakePHP 3.9 End-of-Life

CakePHP 3.9 hat seit Ende 2023 keinen aktiven Security-Support mehr. Das Repo enthält einen Tag `Claninterface_1.1_cakephp4.3`, was auf eine Migration vorbereitet.  
**Empfehlung:** Migration auf CakePHP 4.x oder 5.x abschließen.

---

### 🔵 SUGGESTION — jQuery 3.5.1 (veraltet)

jQuery 3.5.1 ist aus 2020. Aktuelle Version ist 3.7.x. CVEs in der eingesetzten Version prüfen.

---

## 12. Einrichtung & Konfiguration

### Voraussetzungen

```bash
PHP >= 7.3
MariaDB >= 10.4
Apache 2.4 mit mod_rewrite
Composer
```

### Installation

```bash
# 1. Repository klonen
git clone https://github.com/networksecurityvodoo/WoT_1FP_Claninterface.git
cd WoT_1FP_Claninterface/Claninterface

# 2. Abhängigkeiten installieren
composer install --no-dev

# 3. Konfigurationsdateien anlegen
cp config/app_local.example.php config/app_local.php
cp config/external_api.example.php config/external_api.php

# 4. app_local.php bearbeiten: DB-Zugangsdaten, Security.salt
nano config/app_local.php

# 5. external_api.php bearbeiten: WG-API-Key, TS-Zugangsdaten
nano config/external_api.php

# 6. Datenbank anlegen und Migrationen ausführen
bin/cake migrations migrate

# 7. Initiale Daten laden (Ränge)
mysql -u <user> -p <db> < ../sql/data/ranks.sql

# 8. Apache DocumentRoot auf webroot/ zeigen
# AllowOverride All für mod_rewrite setzen

# 9. Crontab einrichten
crontab -e
# Inhalt aus cron_example einfügen und Pfade anpassen
```

### Wichtige Konfigurationsparameter

| Parameter | Datei | Beschreibung |
|---|---|---|
| `Security.salt` | `app_local.php` | Kryptografisches Salt — **unbedingt ändern** |
| `Datasources.default` | `app_local.php` | DB-Verbindung |
| `Wargaming.authkey` | `external_api.php` | WG Developer API-Key |
| `TeamspeakQueryLogin` | `external_api.php` | TS3 ServerQuery-Zugangsdaten |
| `PlayerData.DelAfterDaysLeft` | `external_api.php` | Tage bis Spielerdaten gelöscht werden (default: 14) |
| `Teamspeak.AdminGroups` | `external_api.php` | TS3-Servergruppen-IDs der Admins (vor Kick/Ban geschützt) |

---

## 13. Bekannte Einschränkungen & Offene Punkte

Aus dem README und Code-Analyse:

| Punkt | Status | Hinweis |
|---|---|---|
| DSGVO-Funktionen (Auskunft, Löschung) | ❌ Fehlt | Im README explizit als fehlend markiert |
| DebugController in Produktion | ⚠️ Offen | Muss vor Produktivbetrieb entfernt/gesperrt werden |
| CakePHP 3.9 EOL | ⚠️ Offen | Branch für 4.3 existiert, aber noch nicht gemergt |
| SSL-Verifikation WG-API | ⚠️ Offen | `setSSLVerification(false)` — muss aktiviert werden |
| WN8-Ausgabe via echo | ⚠️ Offen | `WN8Helper::getPlayerWN8()` schreibt direkt HTML |
| Passwort-Mindestlänge | ⚠️ Offen | 3 Zeichen — viel zu niedrig |
| Token-Validierung (WG-OAuth) | ⚠️ Offen | Kein kryptografischer Signatur-Check |
| Sentinel-Wert `1970-01-01` | 🔵 Tech-Debt | Durch NULL ersetzen |
| Frontend-Build-Prozess | 🔵 Offen | SCSS wird nicht kompiliert — kein Asset-Pipeline |
| Tests | 🔵 Unvollständig | Fixture-Dateien vorhanden, TestCase-Klassen leer |

---

## 14. EOL-Status & Migrationsnotwendigkeit

> **Diese Sektion ist sicherheitsrelevant. Bitte vor jedem Produktiveinsatz lesen.**

### Betroffene Komponenten

| Komponente | Eingesetzte Version | EOL seit | Aktuelle Version |
|---|---|---|---|
| **CakePHP** | 3.9.x | Dez. 2023 | 5.x |
| **PHP** | >= 7.3 (Minimum) | Nov. 2021 (7.3), Nov. 2022 (7.4), Nov. 2023 (8.0) | 8.3 (aktiv) |
| **jQuery** | 3.5.1 | — (veraltet) | 3.7.x |
| **phpunit** | ^5\|^6 | — | 10.x / 11.x |
| **Bootstrap** | 4.x (eingebettet) | — (kein aktiver Support) | 5.x |

### Konsequenzen des EOL-Status

- **Keine Security-Patches mehr** für CakePHP 3.9 und PHP < 8.1. Bekannte CVEs werden nicht mehr geschlossen.
- **GitHub Dependabot meldet bereits 9 Schwachstellen** im Repository (1 Critical, 2 High, 1 Moderate, 5 Low) — direkt auf den EOL-Status der Abhängigkeiten zurückzuführen.
- Neu entdeckte Sicherheitslücken in CakePHP 3.x, PHP 7.x oder den eingebetteten JS-Bibliotheken werden **nicht mehr behoben**.
- Kein offizieller Support für Bugreports gegen CakePHP 3.9.

### Migrations-Status im Repository

Ein Migrations-Branch `dev-cakephp_43` / Tag `Claninterface_1.1_cakephp4.3` existiert bereits und enthält substantielle Fortschritte:

- CakePHP 3 → 4.3 abgeschlossen (Templates `.ctp` → `.php`, neue Middleware-Struktur)
- `Auth`-Component → `Authentication` + `Authorization` Plugin migriert
- `RightsHelper` auf rollenbasierte `readonly`-Properties umgebaut (statt numerischem Level)
- PHP-Mindestanforderung auf `>=8.1` angehoben
- Docker-Setup (`docker/`) hinzugefügt
- SSL-Verifikation bleibt jedoch weiterhin deaktiviert (`setSSLVerification(false)`) — **noch nicht behoben**

Die vollständige Migrationsstrategie ist in [MIGRATION_ROADMAP.md](./MIGRATION_ROADMAP.md) beschrieben.

---

*Dokumentation erstellt auf Basis des Quellcode-Stands im `main`-Branch, Juni 2026.*
