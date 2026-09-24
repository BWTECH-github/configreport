# Changelog

All notable changes to this app will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/).

## [0.4.5] - 2026-09-24

### Security

- Externe Speicher im Bericht: Geschwärzt wurden nur Parameter vom Typ Passwort. Versteckte Anmeldeparameter – das OAuth-Token von Google Drive (Zugriffs- und Aktualisierungstoken) und der private Schlüssel der RSA-Anmeldung bei SFTP – sowie Werte, deren Parameter nicht als Passwort deklariert sind (etwa „key“ bei S3 oder alle Werte eines Speichers, dessen App abgeschaltet ist und der deshalb keine Parameterliste hat), standen im Klartext. Jetzt werden versteckte Parameter immer geschwärzt und die Speicherkonfiguration zusätzlich nach Schlüsselnamen geprüft wie die übrigen Konfigurationswerte. Ein neuer Test.

## [0.4.4] - 2026-09-23

### Security

- Geheimnisse werden auch verschachtelt (z. B. redis.cluster → password, objectstore → credentials) und in JSON-Zeichenketten von App-Werten geschwärzt; vorher nur auf der obersten Ebene. Numerische Listenschlüssel gelten nie als Geheimnis. Vier neue Tests.

## [0.4.3] - 2026-09-23

### Fixed

- Geheimnisse im Bericht: Bisher wurde nur „password“ geschwärzt; der Marktplatz-Schlüssel (market → key), API-Schlüssel und Token standen im Klartext. Jetzt werden auch secret, token, salt, credential, api-key, private-key und Schlüssel namens „key“ (bzw. _key/-key/.key) entfernt.
- Download liefert `application/json` statt des nicht registrierten `text/json`.
- Schaltfläche heißt „Download owncloud.online config report“.

## [0.4.2] - 2026-08-13

### Changed

- Marktbeschreibung neu, deutsch und englisch, samt Hinweis auf die entfernte
  Telemetrie und darauf, was der Bericht schwaerzt.

## [0.4.1] - 2026-08-13

### Changed

- Produktname, Beschreibung und uebersetzte Zeichenketten nennen owncloud.online;
  Verweise auf Fehlerbereich, Repository und Dokumentation zeigen auf das eigene
  Repository. Screenshots aus fremden Repositories entfernt.

## [Unreleased]


## [0.3.1] - 2025-05-12

### Changed
- [#208](https://github.com/owncloud/configreport/pull/208) - feat: add more telementry data: apps, shares, tables and storage


## [0.3.0] - 2024-07-08

### Added
- [#197](https://github.com/owncloud/configreport/pull/197) - feat: add daily transmission of config report to ownCloud/kiteworks for business intelligence
- [#200](https://github.com/owncloud/configreport/pull/200) - feat: read /etc/os-release or /etc/lsb-release to get Linux distro information
- [#201](https://github.com/owncloud/configreport/pull/201) - feat: add information to basic report data if running in docker

### Changed
- [#199](https://github.com/owncloud/configreport/pull/199) - fix: process phpinfo() in cli mode as well
- Dependency updates, copyright headers added.


## [0.2.2]  - 2023-08-08

### Changed

- [#183](https://github.com/owncloud/configreport/pull/183) - Hide passwords from the config report
- [#187](https://github.com/owncloud/configreport/pull/187) - Always return an int from Symfony Command execute method 
- [#186](https://github.com/owncloud/configreport/pull/186) - Add helmich/phpunit-json-assert library
- Dependency updates

## [0.2.1] - 2022-04-07

### Added

- Add stats guest_count, renamed count to total_count - [#146](https://github.com/owncloud/configreport/issues/146)

### Changed

- Sanitize system config values - [#171](https://github.com/owncloud/configreport/issues/171)
- Elastic search credentials are obscured. [#170](https://github.com/owncloud/configreport/issues/170)


## 0.2.0 - 2019-04-16

### Added

- Include mounts information in report [#94](https://github.com/owncloud/configreport/issues/94)

### Changed

- Decouple from core, switching to own release cycle
- Drop PHP 5.6 support

[Unreleased]: https://github.com/owncloud/configreport/compare/v0.3.1..master
[0.3.1]: https://github.com/owncloud/configreport/compare/v0.3.0..v0.3.1
[0.3.0]: https://github.com/owncloud/configreport/compare/v0.2.2..v0.3.0
[0.2.2]: https://github.com/owncloud/configreport/compare/v0.2.1..v0.2.2
[0.2.1]: https://github.com/owncloud/configreport/compare/v0.2.0..v0.2.1

