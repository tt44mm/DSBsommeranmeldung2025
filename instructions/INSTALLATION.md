# Installation Guide

## Voraussetzungen

- PHP 7.4 oder höher
- MySQL 5.7 oder höher
- Webserver (Apache/Nginx)
- Git

## Installationsschritte

1. Repository klonen:
   ```bash
   git clone git@github.com:tt44mm/DSBsommeranmeldung2025.git
   ```

2. Verzeichnis wechseln:
   ```bash
   cd DSBsommeranmeldung2025
   ```

3. Berechtigungen setzen:
   - Stellen Sie sicher, dass der Webserver Schreibrechte für folgende Verzeichnisse hat:
     - `uploads/` (falls vorhanden)
     - Temporäre Verzeichnisse für Dateiuploads

4. Webserver konfigurieren:
   - Dokumentroot auf das Hauptverzeichnis zeigen lassen
   - PHP-Module aktivieren (mysqli, mail, etc.)

5. Datenbank einrichten:
   - MySQL-Datenbank erstellen
   - Benutzer mit entsprechenden Rechten anlegen
   - Datenbankstruktur importieren (falls SQL-Dump vorhanden)
