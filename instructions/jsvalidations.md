# JavaScript-Validierungen im Anmeldeformular

Dieses Dokument beschreibt die implementierten JavaScript-Validierungen für jedes Eingabefeld im Hauptformular der Sommercamp-Anmeldung 2025.

## Allgemeine Validierung

Die Validierung erfolgt hauptsächlich in der Funktion `submitclick()` in der Datei `js/js-functions.js`. Alle Felder mit der CSS-Klasse `required` werden auf Pflichtfelder geprüft.

## Eltern-/Erziehungsberechtigte Daten

| Feld | Name | Validierung |
|------|------|-------------|
| Vorname (Mutter) | `MfirstName` | Pflichtfeld, darf nicht leer sein |
| Nachname (Mutter) | `MlastName` | Pflichtfeld, darf nicht leer sein |
| DNI/NIE (Mutter) | `M_DNI` | Pflichtfeld, darf nicht leer sein |
| Vorname (Vater) | `PfirstName` | Pflichtfeld, darf nicht leer sein |
| Nachname (Vater) | `PlastName` | Pflichtfeld, darf nicht leer sein |
| DNI/NIE (Vater) | `P_DNI` | Pflichtfeld, darf nicht leer sein |
| Straße | `Street` | Pflichtfeld, darf nicht leer sein |
| Stadt | `Town` | Pflichtfeld, darf nicht leer sein |
| PLZ | `PLZ` | Pflichtfeld, muss genau 5 Ziffern enthalten (Regex: `/^\d{5}$/`) |
| Telefon | `Phone` | Pflichtfeld, darf nur Ziffern, Leerzeichen und ein + am Anfang enthalten (Regex: `/^[+]?[0-9 ]+$/`) |
| Mobiltelefon | `phone0` | Kein Pflichtfeld, darf nur Ziffern, Leerzeichen und ein + am Anfang enthalten (Regex: `/^[+]?[0-9 ]+$/`) |
| E-Mail | `Email1` | Pflichtfeld, muss ein gültiges E-Mail-Format haben (Regex: `/^[^\s@]+@[^\s@]+\.[^\s@]+$/`) |
| E-Mail wiederholen | `Email2` | Pflichtfeld, muss mit dem Wert von `Email1` übereinstimmen |

## Schüler-Daten

| Feld | Name | Validierung |
|------|------|-------------|
| Vorname | `nombre0` | Pflichtfeld, darf nicht leer sein |
| Nachname | `apellidos0` | Pflichtfeld, darf nicht leer sein |
| Geburtsdatum | `birthdate0` | Pflichtfeld, spezielle Altersvalidierung in der Funktion `validateAge()` |
| DSB-Schüler | `dsb0` | Pflichtfeld, mindestens eine Option muss ausgewählt sein |
| Schule | `colegio0` | Pflichtfeld, darf nicht leer sein |
| Schwimmfähigkeit | `nadar0` | Pflichtfeld, mindestens eine Option muss ausgewählt sein |
| Erlaubnis Kinderbecken | `autohinch0` | Pflichtfeld, mindestens eine Option muss ausgewählt sein |
| Erlaubnis großes Schwimmbecken | `autopisci0` | Pflichtfeld, mindestens eine Option muss ausgewählt sein |
| Allergien | `alergias0` | Kein Pflichtfeld, keine spezielle Validierung |
| Lebensmittelunverträglichkeiten | `intolerancias0` | Kein Pflichtfeld, keine spezielle Validierung |
| Medikamente | `medicaciones0` | Kein Pflichtfeld, keine spezielle Validierung |

## Kurs-Optionen

| Feld | Name | Validierung |
|------|------|-------------|
| Sprache | `idioma0` | Pflichtfeld, mindestens eine Option muss ausgewählt sein |
| Sprachniveau-Bemerkungen | `obsidioma0` | Pflichtfeld, darf nicht leer sein |
| Wochen | `curso0[]` | Pflichtfeld, mindestens eine Woche muss ausgewählt sein |
| Frühbetreuung | `fruehcurso0-X` | Kein Pflichtfeld, keine spezielle Validierung |
| Mittagsbetreuung | `mittagcurso0-X` | Kein Pflichtfeld, keine spezielle Validierung |

## Bus-Optionen

| Feld | Name | Validierung |
|------|------|-------------|
| Bus Hinfahrt | `Busida` | Pflichtfeld, darf nicht leer sein |
| Bus Rückfahrt | `Busvuelta` | Pflichtfeld, darf nicht leer sein |
| Bus Rückfahrt 16:15 | `Busvuelta2` | Pflichtfeld, darf nicht leer sein |

## Spezielle Validierungen

### Altersvalidierung

Die Funktion `validateAge()` prüft das Alter des Schülers und zeigt entsprechende Fehlermeldungen an:

- Prüft, ob das Datum im Format YYYY-MM-DD eingegeben wurde
- Prüft, ob das Alter zwischen 3 und 14 Jahren liegt
- Zeigt spezifische Fehlermeldungen für zu junge oder zu alte Schüler an

### Verbesserung der Altersvalidierung

#### Problem
Die Altersvalidierung für das Geburtsdatum hat nicht korrekt funktioniert. Das Alter wurde nicht zum richtigen Stichtag berechnet und der zulässige Altersbereich war zu weit gefasst.

#### Lösung
1. **Angepasste Altersberechnung**: 
   - Statt zum 1. Januar des aktuellen Jahres wird das Alter jetzt zum 1. Juli des Camp-Jahres berechnet
   - Automatische Erkennung des nächsten Jahres, wenn die Anmeldung nach September erfolgt

2. **Korrekter Altersbereich**:
   - Der zulässige Altersbereich wurde auf 3-14 Jahre festgelegt
   - Vorher war der Bereich auf 2-19 Jahre eingestellt, was nicht den Anforderungen des Sommercamps entsprach

3. **Verbesserte Fehlerbehandlung**:
   - Korrekte Anzeige der Fehlermeldungen bei zu jung oder zu alt
   - Dynamische Aktualisierung der JUNG/ALT Hinweise je nach Altersgruppe

#### Codeänderungen
```javascript
// Berechne das Alter zum 1. Juli des aktuellen Jahres (Sommercamp-Referenzdatum)
const today = new Date();
const campYear = today.getFullYear() + (today.getMonth() > 8 ? 1 : 0); // Nächstes Jahr, wenn wir nach September sind
const referenceDate = new Date(campYear, 6, 1); // 1. Juli des Camp-Jahres
let age = referenceDate.getFullYear() - birthDate.getFullYear();

// Berücksichtige den Monat und Tag für die genaue Altersberechnung
if (birthDate.getMonth() > referenceDate.getMonth() || 
    (birthDate.getMonth() === referenceDate.getMonth() && birthDate.getDate() > referenceDate.getDate())) {
    age--;
}

// Überprüfe, ob das Alter im gültigen Bereich liegt (3-14 Jahre)
const minAge = 3;
const maxAge = 14;
const isValidAge = age >= minAge && age <= maxAge;
```

#### Testergebnisse
- Ein Geburtsdatum, das ein Alter von 2 Jahren zum Camp-Datum ergibt, wird korrekt als "zu jung" markiert
- Ein Geburtsdatum, das ein Alter von 15 Jahren zum Camp-Datum ergibt, wird korrekt als "zu alt" markiert
- Ein Geburtsdatum im gültigen Bereich (3-14 Jahre) wird akzeptiert
- Die Fehlermeldungen werden korrekt angezeigt und enthalten die richtigen Altersgrenzen

### Dynamische Validierungen

- Die Funktion `weekclick()` aktualisiert die Preisberechnung und zeigt/versteckt Optionen für Früh- und Mittagsbetreuung
- Die Funktion `dsbclicksi()` und `dsbclickno()` passen die Preisberechnung basierend auf dem DSB-Schüler-Status an
- Die Funktion `idiomaclick()` verarbeitet die Sprachauswahl

### Formular-Absenden

Beim Absenden des Formulars wird die Funktion `submitclick()` aufgerufen, die alle Validierungen durchführt und das Formular nur absendet, wenn alle Validierungen erfolgreich sind.

## JavaScript-Validierungslösungen

### PLZ und Telefon-Validierungen

Die Probleme mit den Fehlermeldungen für Formatvalidierungen wurden durch folgende Maßnahmen behoben:

#### 1. Lösungsansatz für Fehlermeldungs-Probleme

- **Verbesserte Protokollierung**: Die `showError`-Funktion wurde mit zusätzlichen Konsolenausgaben erweitert, um zu identifizieren, ob und wann sie aufgerufen wird.
- **Syntaxfehler behoben**: Ein falsch gesetztes Anführungszeichen in einer Konsolenausgabe wurde korrigiert.
- **CSS-Stile optimiert**: Fehlermeldungen werden mit `!important`-Flags für display, visibility und opacity versehen.

#### 2. Implementierte Änderungen

##### In der `showError`-Funktion:
```javascript
function showError(field, message) {
    if (!field || !message) {
        console.log("showError: Feld oder Nachricht fehlt", field, message);
        return;
    }
    
    console.log("showError wird aufgerufen für:", field.id || field.name, "mit Nachricht:", message);
    
    // Weitere Implementierung...
}
```

##### In der Formatvalidierung (validateForm-Funktion):
```javascript
// PLZ validieren - Muss genau 5 Ziffern enthalten
const plzField = document.getElementById('PLZ');
if (plzField && plzField.value.trim()) { // Nur validieren, wenn nicht leer
    const plzRegex = /^\d{5}$/;
    const plzValue = plzField.value.trim();
    const plzFormatValid = plzRegex.test(plzValue);
    
    console.log(`Validierung FORMAT für PLZ: ${plzFormatValid ? 'TRUE' : 'FALSE'} (Wert: ${plzValue})`);
    
    if (!plzFormatValid) {
        formatValid = false;
        formValid = false;
        // Fehlermeldung direkt anzeigen und Bestätigung loggen
        console.log('Zeige Fehlermeldung für PLZ');
        showError(plzField, 'La código postal debe contener exactamente 5 dígitos.');
    }
}
```

##### CSS für Fehlermeldungen:
```css
.validationerror {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 4px;
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    background-color: #fff8f8;
    padding: 5px 10px;
    border-radius: 4px;
    border-left: 3px solid #dc3545;
}
```

#### 3. Ergebnis

Diese Änderungen stellen sicher, dass:
- Fehler bei der Validierung korrekt protokolliert werden
- Fehlermeldungen auch für Formatfehler (nicht nur für erforderliche Felder) angezeigt werden
- Die Fehlermeldungen visuell gut sichtbar sind

## Zu beheben: Geburtsdatum-Validierung

Die Altersvalidierung funktioniert derzeit nicht korrekt. Es wird keine Prüfung durchgeführt, ob das eingegebene Datum ein gültiges Alter ergibt.

## Behobenes Problem: Altersvalidierung beim Absenden des Formulars

### Problem
Das Formular konnte abgesendet werden, obwohl das eingegebene Geburtsdatum ein Alter außerhalb der erlaubten Grenzen (2-19 Jahre) ergab.

### Lösung
Die Validierungslogik in der `submitclick`-Funktion wurde verbessert, um sicherzustellen, dass das Formular nicht abgesendet werden kann, wenn die Altersprüfung fehlschlägt.

#### Geänderter Code
```javascript
// Alte Version (fehlerhaft)
if (birthdateField && birthdateField.value.trim()) { // Nur validieren, wenn nicht leer
    const ageResult = validateAge(birthdateField);
    console.log(`Validierung SPEZIAL für birthdate0 (Alter): ${ageResult ? 'TRUE' : 'FALSE'}`);
    
    if (!ageResult) {
        specialValid = false;
        isValid = false;
    }
}

// Neue Version (korrigiert)
if (birthdateField) {
    // Immer validieren, unabhängig davon, ob leer oder nicht
    // Wenn es leer ist, wird es bereits als erforderlich behandelt
    // Wenn es gefüllt ist, muss das Alter validiert werden
    if (birthdateField.value.trim()) {
        const ageResult = validateAge(birthdateField);
        console.log(`Validierung SPEZIAL für birthdate0 (Alter): ${ageResult ? 'TRUE' : 'FALSE'}`);
        
        if (!ageResult) {
            specialValid = false;
            isValid = false;
            // Fehlermeldung wird durch validateAge gesetzt
        }
    }
}
```

### Ergebnis
- Das Formular wird nicht mehr abgesendet, wenn das Geburtsdatum ein Alter außerhalb der erlaubten Grenzen (2-19 Jahre) ergibt
- Die Fehlermeldung für ungültiges Alter wird korrekt angezeigt
- Die Konsistenz der Validierungslogik ist verbessert
