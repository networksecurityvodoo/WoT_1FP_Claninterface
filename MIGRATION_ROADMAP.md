# Migration Roadmap — WoT 1FP Claninterface

> **Ziel:** Ablösung des EOL-Stacks (CakePHP 3.9 / PHP 7.3) durch einen unterstützten, sicherheitsgepatchten Stack.  
> **Ausgangspunkt:** Branch `dev-cakephp_43` (bereits weit fortgeschritten)  
> **Endziel:** CakePHP 5.x + PHP 8.3 + aktuelle Frontend-Dependencies

---

## EOL-Übersicht

| Komponente | main-Branch | EOL seit | Zielversion |
|---|---|---|---|
| CakePHP | 3.9.x | **Dez. 2023** | 5.1.x |
| PHP | >= 7.3 | **Nov. 2021** (7.3) | 8.3 |
| jQuery | 3.5.1 | — (veraltet) | 3.7.x |
| Bootstrap | 4.x | — (kein aktiver Support) | 5.x |
| phpunit | ^5\|^6 | — | 11.x |

> GitHub Dependabot meldet bereits **9 offene Schwachstellen** (Stand: Juni 2026) im main-Branch.

---

## Migrationspfad

Die empfohlene Strategie ist ein **zweistufiger Upgrade-Pfad**, da direktes 3→5 zu viele Breaking Changes auf einmal einführt. Phase 1 ist im Repository bereits weitgehend abgeschlossen.

```
CakePHP 3.9 / PHP 7.3   (main, EOL)
        ↓  Phase 1 (bereits in dev-cakephp_43)
CakePHP 4.5 / PHP 8.1
        ↓  Phase 2
CakePHP 5.1 / PHP 8.3   (Ziel)
```

---

## Phase 1 — CakePHP 3 → 4 (Branch: `dev-cakephp_43`)

### Status: ~80% abgeschlossen

#### Bereits umgesetzt ✅

| Bereich | Änderung |
|---|---|
| Framework | CakePHP `3.9.*` → `^4.3.0` |
| PHP | Mindestanforderung `>=8.1` |
| Templates | Alle `.ctp`-Dateien → `.php` (`src/Template/` → `templates/`) |
| Auth | `Auth`-Component entfernt → `Authentication` + `Authorization` Plugin |
| `RightsHelper` | Numerisches Level-System → rollenbasierte `readonly bool`-Properties |
| AppController | `initialize()` mit Return-Type `void`, neue Auth-Komponenten eingebunden |
| Docker | `docker/Dockerfile` + `docker-compose.yml` hinzugefügt |
| Migration | Neue initiale Migration `20220110112020_Initial.php` für CakePHP-4-Schema |
| `UsersController` | Stark überarbeitet, neues Auth-System integriert |
| `UserPolicy` | `src/Policy/UserPolicy.php` neu angelegt (Authorization-Plugin) |

#### Noch offen / Bekannte Probleme ⚠️

| Problem | Datei | Priorität |
|---|---|---|
| `setSSLVerification(false)` weiterhin aktiv | `WgApi.php` | 🔴 Critical |
| `isAuthorized()` in AppController noch vorhanden (CakePHP-3-Pattern) | `AppController.php` | 🔴 Blocker |
| `getPermissionLevel()` entfernt, aber Aufruf-Stellen in Controllers noch nicht vollständig portiert | mehrere Controller | 🟡 High |
| DebugController noch aktiv und public | `DebugController.php` | 🔴 Critical |
| `Shell/ConsoleShell.php` (CakePHP 3 Shell, deprecated) | `ConsoleShell.php` | 🟡 High |
| Passwort-Mindestlänge 3 Zeichen unverändert | `UsersTable.php` | 🔴 Critical |
| WG-OAuth-Callback ohne Signaturprüfung | `TokensController.php` | 🔴 Critical |
| `echo`-Statements in `WN8Helper` | `WN8Helper.php` | 🟡 Medium |
| Tests: Fixtures vorhanden, TestCases leer | `tests/TestCase/` | 🔵 Low |

#### Aufgaben zum Abschluss von Phase 1

```
[ ] dev-cakephp_43 → main mergen (nach Abschluss der offenen Punkte)
[ ] SSL-Verifikation aktivieren: $api->setSSLVerification(true)
[ ] isAuthorized()-Pattern durch Authorization-Plugin-Policies ersetzen
[ ] DebugController löschen oder hinter permissionLevel >= 10 sperren
[ ] Shell/ConsoleShell.php auf CakePHP-4-Command-API migrieren
[ ] Passwort-Mindestlänge auf >= 12 Zeichen erhöhen
[ ] WG-OAuth: openid_sig-Validierung implementieren
[ ] WN8Helper: echo-Statements durch Rückgabewerte ersetzen
[ ] composer update --dry-run ausführen, Dependabot-Alerts abarbeiten
[ ] PHPUnit von ^5|^6 auf ^10 aktualisieren, Tests lauffähig machen
```

---

## Phase 2 — CakePHP 4 → 5

> Erst nach vollständigem Abschluss von Phase 1 beginnen.

### Breaking Changes CakePHP 4 → 5

| Bereich | Änderung |
|---|---|
| PHP-Mindestanforderung | `>=8.1` → `>=8.1` (unverändert, aber 8.3 empfohlen) |
| `Cake\Http\ServerRequest` | `getParam()` und einige Methoden umbenannt |
| ORM: `TableRegistry` | `TableRegistry::getTableLocator()` weiterhin verfügbar, aber `Cake\ORM\Locator\LocatorAwareTrait` bevorzugt |
| `patchEntity()` | Strikte Typ-Validierung verschärft |
| Middleware | `RoutingMiddleware` API-Änderungen |
| Templates | `.php`-Dateien unverändert kompatibel ✅ |
| Events | `Cake\Event\Event` → `Cake\Event\EventInterface` in Signaturen |
| Auth-Plugins | `Authentication` + `Authorization` bereits CakePHP-5-kompatibel ✅ |

### Schrittweise Migration

```
1. composer require cakephp/cakephp:^5.0 --dry-run
   → Alle Konflikte analysieren

2. Deprecation-Warnings in CakePHP 4 aktivieren (debug-Level), alle beheben
   Configure::write('Error.errorLevel', E_ALL);

3. ORM-Aufrufe: TableRegistry::getTableLocator() → $this->fetchTable() (bevorzugt)

4. Controller: $this->request->getParam() auf aktuelle API prüfen

5. composer update auf CakePHP 5

6. bin/cake migrations migrate (Migrations bleiben kompatibel)

7. Test-Suite ausführen: bin/cake test
```

---

## Frontend-Modernisierung (parallel möglich)

Diese Schritte sind unabhängig vom PHP/CakePHP-Upgrade und können parallel erledigt werden.

### jQuery 3.5.1 → 3.7.x

```bash
# Datei ersetzen:
# webroot/js/jquery-3.5.1.js → jquery-3.7.x.js
# webroot/js/jquery-3.5.1.min.js → jquery-3.7.x.min.js
# Alle Template-Referenzen aktualisieren
grep -r "jquery-3.5" templates/ src/Template/
```

### Bootstrap 4 → 5

> **Achtung: Breaking Changes.** Bootstrap 5 entfernt jQuery als Abhängigkeit und benennt viele CSS-Klassen um.

Wichtigste Änderungen für dieses Projekt:

| Bootstrap 4 | Bootstrap 5 | Dateien betroffen |
|---|---|---|
| `data-toggle` | `data-bs-toggle` | alle Templates mit Modals/Dropdowns |
| `data-dismiss` | `data-bs-dismiss` | Flash-Messages, Modals |
| `ml-*` / `mr-*` | `ms-*` / `me-*` | alle Templates |
| `float-left` / `float-right` | `float-start` / `float-end` | alle Templates |
| jQuery-abhängige JS-Komponenten | vanilla JS | `webroot/js/` |

Empfehlung: Bootstrap-5-Migration mit [Bootstrap Migration Guide](https://getbootstrap.com/docs/5.0/migration/) + manuellem Template-Review.

### Font Awesome 5 → 6

Weitgehend rückwärtskompatibel. CDN-Link oder aktuelles Package einbinden.

---

## Docker-Setup (bereits in `dev-cakephp_43`)

Der Branch enthält ein funktionsfähiges Docker-Setup:

```yaml
# docker/docker-compose.yml
# Services: PHP-FPM + MariaDB + Apache
```

```dockerfile
# docker/Dockerfile
# Basis: PHP 8.1-FPM
```

Für Produktion empfohlen:
- Secrets per Docker Secrets oder `.env` (nicht im Image)
- Readonly-Filesystem für App-Container
- Separater Cron-Container für CLI-Commands

---

## Sicherheits-Checkliste vor Go-Live (Phase 1 + 2)

Nach Abschluss der Migration **vor** Produktivbetrieb prüfen:

```
Sicherheit
[ ] SSL-Verifikation WG-API aktiviert
[ ] DebugController entfernt
[ ] WG-OAuth openid_sig-Validierung implementiert
[ ] Passwort-Mindestlänge >= 12 Zeichen
[ ] Rate-Limiting für Login + Passwort-Reset (z.B. via Apache mod_evasive oder App-Middleware)
[ ] Security.salt geändert (app_local.php)
[ ] HTTPS erzwungen (HSTS-Header in Apache-Config)
[ ] Content-Security-Policy Header gesetzt
[ ] $this->loadComponent('FormProtection') aktiviert und getestet

Abhängigkeiten
[ ] composer audit — keine bekannten CVEs
[ ] jQuery aktuell
[ ] Bootstrap aktuell

Betrieb
[ ] DSGVO-Funktionen implementiert (Auskunft, Löschung — noch nicht vorhanden)
[ ] Logging konfiguriert (kein Stack-Trace in Prod-Logs)
[ ] Backup-Strategie für MariaDB
[ ] Monitoring für Cron-Jobs (z.B. via Healthchecks.io oder selbst gehostet)
```

---

## Referenzen

- [CakePHP 3 → 4 Migration Guide](https://book.cakephp.org/4/en/appendices/4-0-migration-guide.html)
- [CakePHP 4 → 5 Migration Guide](https://book.cakephp.org/5/en/appendices/5-0-migration-guide.html)
- [CakePHP Authentication Plugin](https://book.cakephp.org/authentication/2/en/index.html)
- [CakePHP Authorization Plugin](https://book.cakephp.org/authorization/2/en/index.html)
- [Bootstrap 4 → 5 Migration](https://getbootstrap.com/docs/5.0/migration/)
- [PHP Supported Versions](https://www.php.net/supported-versions.php)

---

*Roadmap erstellt auf Basis der Branch-Analyse `main` vs. `dev-cakephp_43`, Juni 2026.*
