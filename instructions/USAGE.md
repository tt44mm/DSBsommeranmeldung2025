# Verwendung des Anmeldeformulars

## Für Benutzer

1. Öffnen Sie `anmeldungsommercamp_2025.php` im Webbrowser
2. Füllen Sie alle erforderlichen Felder aus:
   - Persönliche Daten
   - Sprachauswahl
   - Gewünschte Wochen
   - Zusätzliche Optionen
3. Formular absenden und Bestätigung abwarten

## Visuelle Indikatoren im Formular

### Pflichtfelder
- Alle Pflichtfelder sind mit einem roten Stern (*) gekennzeichnet
- Bei fehlender Eingabe werden diese Felder rot markiert

### Validierungszustände
- **Erfolgreiche Validierung**: Grüne Umrandung um Formularelemente
- **Fehlerhafte Validierung**: Rote Umrandung und Fehlermeldung unter dem Feld
- **Checkboxen und Radio-Buttons**: 
  - Die Beschriftungen werden farbig markiert (grün für gültig, rot für ungültig)
  - Die Checkboxen bleiben quadratisch und werden vom Browser-Standard gerendert
  - Die Checkboxenhaken werden einheitlich angezeigt, ohne Doppeldarstellung

## Spezialfunktionen

### Sprachauswahl
- Die Auswahl der Sprache (Deutsch/Spanisch) hat Einfluss auf die angezeigten Optionen
- Nach der Auswahl werden zukünftige Felder entsprechend angepasst

### Kurswochen
- Die Auswahl der Kurswochen aktiviert zugehörige Optionen (Frühbetreuung, Mittagessen)
- Die Preise werden automatisch aktualisiert

### Mehrere Kinder
- Für jedes weitere Kind können Sie auf "Weiteres Kind hinzufügen" klicken
- Die Validierung erfolgt für jedes Kind separat

## Für Administratoren

1. Überprüfen der Anmeldungen:
   - Zugriff auf die Datenbank
   - E-Mail-Bestätigungen kontrollieren

2. Datenpflege:
   - Regelmäßige Backups erstellen
   - Alte Einträge archivieren

3. Fehlerbehebung:
   - Log-Dateien überprüfen
   - E-Mail-Versand testen
   - Formularvalidierung überprüfen

## Bekannte Besonderheiten

1. **Checkbox- und Radio-Button-Darstellung**:
   - Die Darstellung dieser Elemente verwendet Browser-native Styling-Optionen
   - Entscheidend ist die CSS-Konfiguration in `dsbform_2.css` und `validation-styles.css`
   - Änderungen an diesen Elementen erfordern besondere Sorgfalt, um die Konsistenz zu wahren

2. **Mobiles Responsive Design**:
   - Das Formular ist für verschiedene Bildschirmgrößen optimiert
   - Auf kleineren Bildschirmen werden die Formularelemente angepasst dargestellt

3. **Browser-Kompatibilität**:
   - Das Formular ist mit allen modernen Browsern kompatibel
   - Für optimale Darstellung wird Chrome oder Firefox empfohlen
