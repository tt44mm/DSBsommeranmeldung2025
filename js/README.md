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

## Historische Entwicklung
Das System wurde schrittweise von jQuery auf reines JavaScript umgestellt.
Einige Funktionen sind daher in beiden Dateien in leicht unterschiedlicher Form vorhanden.

## Validierungsfunktionen
Bestimmte Validierungsfunktionen wie `validatePLZ`, `validatePhone` werden direkt in js-functions.js definiert,
während ähnliche Validierungen in pure-validation.js über das `validationRules`-Objekt implementiert sind.

## Wartungshinweise
Bei Änderungen an Validierungsfunktionen immer beide Dateien berücksichtigen und sicherstellen,
dass die Logik konsistent bleibt.
