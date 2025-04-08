# JavaScript-Dokumentation für das DSB-Anmeldesystem

## Dateistruktur und Funktionsaufteilung

Das Anmeldesystem verwendet zwei Haupt-JavaScript-Dateien:

### js-functions.js
- UI-Funktionen (Animationen, Formularinteraktionen)
- Einfache Validierungsfunktionen (direkter Aufruf bei Ereignissen)
- Preisberechnungen und Wochenauswahl-Logik
- Spezielle Validierungen (z.B. Altersvalidierung)

### pure-validation.js
- Umfassendes Validierungssystem für das gesamte Formular
- Regel-basierter Ansatz mit zentraler Validierungslogik
- Event-Handler für Formularfelder
- Komplexe Fehlerbehandlung für verschiedene Feldtypen

## CSS-Interaktionen
Die JavaScript-Funktionen interagieren mit den CSS-Dateien, insbesondere:
- `validation-styles.css`: Anwendung von Validierungszuständen auf Formularelemente
- `dsbform_2.css`: Steuert die visuelle Darstellung der Formularelemente (Checkboxen, Radio-Buttons)

## Formularelemente

### Checkboxen und Radio-Buttons
- Die `dsbcheckbox`-Klasse wird für speziell gestylte Checkboxen verwendet
- Sorgfältige Beachtung der HTML-Struktur ist wichtig bei CSS-Anpassungen
- Die Form und Farbe werden durch spezielle CSS-Regeln gesteuert

### Event-Handling
- Wichtige Event-Handler:
  - `weekclick()`: Verwaltet die Auswahl der Wochen und zugehörige Optionen
  - `dsbclicksi()` und `dsbclickno()`: Verwalten die Auswahl mit Ja/Nein-Optionen
  - `idiomaclick()`: Verwaltet die Sprachauswahl

## Historische Entwicklung
Das System wurde schrittweise von jQuery auf reines JavaScript umgestellt.
Einige Funktionen sind daher in beiden Dateien in leicht unterschiedlicher Form vorhanden.

## Validierungsfunktionen
Bestimmte Validierungsfunktionen wie `validatePLZ`, `validatePhone` werden direkt in js-functions.js definiert,
während ähnliche Validierungen in pure-validation.js über das `validationRules`-Objekt implementiert sind.

## Bekannte Besonderheiten
- Die Formularstile, besonders für Checkboxen, erfordern spezielle CSS-Regeln, um konsistent zu erscheinen
- Vermeidung von doppelten Haken wird durch sorgfältige CSS-Steuerung erreicht
- Für mobile Geräte gelten spezielle Anpassungen der Formularelemente

## Wartungshinweise
- Bei Änderungen an Validierungsfunktionen immer beide JavaScript-Dateien berücksichtigen
- Bei CSS-Anpassungen die Struktur der HTML-Elemente beachten, insbesondere bei der `dsbcheckbox`-Klasse
- Beim Styling von Checkboxen und Radio-Buttons die Interaktion zwischen CSS und JavaScript berücksichtigen
