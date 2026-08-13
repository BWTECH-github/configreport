# Konfigurationsbericht

Erzeugt auf Knopfdruck eine Zusammenfassung der Serverkonfiguration — als
JSON-Datei zum Herunterladen. Gedacht für Support-Anfragen und Fehlermeldungen.

## Was drinsteht

* Version, Kanal und Betriebszustand des Servers
* Inhalt der `config.php`
* installierte und aktivierte Apps samt Version
* Datenbank: Typ, Version, Tabellenübersicht
* PHP-Version, geladene Erweiterungen, relevante `php.ini`-Werte
* eingebundene externe Speicher
* Übersicht über Freigaben und belegten Speicher

**Passwörter und Geheimnisse werden ersetzt**, bevor der Bericht entsteht —
`dbpassword`, `passwordsalt`, `secret`, Zugangsdaten externer Speicher und
Ähnliches. Der Bericht lässt sich damit weitergeben, ohne dass Zugangsdaten
mitgehen. Sehen Sie ihn trotzdem durch, bevor Sie ihn aus der Hand geben: Pfade,
Hostnamen und Benutzernamen stehen darin.

## Voraussetzungen

* owncloud.online 11.x
* PHP 8.4

## Installation

Über den Market, oder von Hand:

```bash
cd /var/www/owncloud.online/apps
git clone https://github.com/BWTECH-github/configreport.git
chown -R www-data:www-data configreport
sudo -u www-data php8.4 ../occ app:enable configreport
```

## Benutzung

**Weboberfläche:** Einstellungen → Allgemein → *Konfigurationsbericht erzeugen*.
Der Bericht wird als Datei heruntergeladen.

**Kommandozeile:**

```bash
sudo -u www-data php8.4 occ configreport:generate > bericht.json
```

Der Weg über die Kommandozeile ist der zuverlässigere, wenn die Weboberfläche
nicht mehr erreichbar ist — also genau dann, wenn man den Bericht am dringendsten
braucht.

## Unterschied zur ursprünglichen App

Die Vorlage verschickte einmal täglich einen Teil dieser Daten an einen Server
des Ursprungsprojekts (`telemetry.owncloud.com`), sofern ein Lizenzschlüssel
hinterlegt war; abschalten ließ sich das nur über
`'telemetry.enabled' => false`. Diese Funktion ist hier vollständig entfernt.
Der Bericht entsteht nur, wenn Sie ihn anfordern, und verlässt den Server nur
dadurch, dass Sie ihn weitergeben.

## Herkunft

Fork der gleichnamigen ownCloud-App, gepflegt von der BW-Tech GmbH für
owncloud.online und PHP 8.4. Lizenz: AGPLv3.
