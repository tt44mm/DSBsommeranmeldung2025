# DSB Sommeranmeldung 2025

Dieses Projekt ist ein Anmeldeformular für das DSB Sommercamp 2025. Es besteht aus einer PHP-basierten Webanwendung mit JavaScript-Validierung.

## Projektstruktur

- `anmeldungsommercamp_2025.php`: Hauptdatei des Anmeldeformulars.
- `js/js-functions.js`: JavaScript-Funktionen für die Validierung und Interaktivität.
- `js/pure-validation.js`: Erweitertes Validierungssystem für komplexe Formularvalidierung.
- `css/dsbform_2.css`: Hauptstildatei für das Formulardesign.
- `css/validation-styles.css`: Spezielle Stile für Validierungszustände.
- `includes/`: Verzeichnis mit zusätzlichen PHP-Dateien für die Datenverarbeitung und E-Mail-Versand.

## Technologien

- PHP
- JavaScript (Vanilla JS ohne Framework-Abhängigkeiten)
- HTML/CSS
- Bootstrap 4.3.1 als CSS-Framework
- MySQL (für die Datenspeicherung)

## Installation

1. Klonen Sie das Repository:
   ```bash
   git clone git@github.com:tt44mm/DSBsommeranmeldung2025.git
   ```

2. Konfigurieren Sie die Datenbankverbindung in `includes/connect_data.php`.

3. Stellen Sie sicher, dass der Webserver korrekt eingerichtet ist und PHP unterstützt.

## Verwendung

Öffnen Sie `anmeldungsommercamp_2025.php` in einem Webbrowser, um das Anmeldeformular aufzurufen.

## Bekannte Besonderheiten

- Die Formularelemente (insbesondere Checkboxen und Radio-Buttons) verwenden spezielle CSS-Regeln, um konsistente Darstellung in verschiedenen Browsern zu gewährleisten.
- Die Formularvalidierung erfolgt sowohl client-seitig (JavaScript) als auch server-seitig (PHP).

## Dokumentation

Weitere Informationen finden Sie in den Dokumentationsdateien im Verzeichnis `instructions/`:
- INSTALLATION.md: Installationsanleitung
- CONFIGURATION.md: Konfigurationsleitfaden
- USAGE.md: Benutzerhandbuch
- jsvalidations.md: Dokumentation der JavaScript-Validierungsfunktionen

## Lizenz

Dieses Projekt ist lizenziert unter der MIT-Lizenz.
