# JavaScript-Validierungen im Anmeldeformular

Dieses Dokument beschreibt die implementierten JavaScript-Validierungen fu00fcr jedes Eingabefeld im Hauptformular der Sommercamp-Anmeldung 2025.

## Allgemeine Validierung

Die Validierung erfolgt hauptsu00e4chlich in der Funktion `submitclick()` in der Datei `js/js-functions.js`. Alle Felder mit der CSS-Klasse `required` werden auf Pflichtfelder gepru00fcft.

## Eltern-/Erziehungsberechtigte Daten

| Feld | Name | Validierung |
|------|------|-------------|
| Vorname (Mutter) | `MfirstName` | Pflichtfeld, darf nicht leer sein |
| Nachname (Mutter) | `MlastName` | Pflichtfeld, darf nicht leer sein |
| DNI/NIE (Mutter) | `M_DNI` | Pflichtfeld, darf nicht leer sein |
| Vorname (Vater) | `PfirstName` | Pflichtfeld, darf nicht leer sein |
| Nachname (Vater) | `PlastName` | Pflichtfeld, darf nicht leer sein |
| DNI/NIE (Vater) | `P_DNI` | Pflichtfeld, darf nicht leer sein |
| Strau00dfe | `Street` | Pflichtfeld, darf nicht leer sein |
| Stadt | `Town` | Pflichtfeld, darf nicht leer sein |
| PLZ | `PLZ` | Pflichtfeld, darf nicht leer sein |
| Telefon | `Phone` | Pflichtfeld, darf nicht leer sein |
| Mobiltelefon | `phone0` | Pflichtfeld, darf nicht leer sein |
| E-Mail | `Email1` | Pflichtfeld, muss ein gu00fcltiges E-Mail-Format haben (Regex: `/^[^\s@]+@[^\s@]+\.[^\s@]+$/`) |
| E-Mail wiederholen | `Email2` | Pflichtfeld, muss mit dem Wert von `Email1` u00fcbereinstimmen |

## Schu00fcler-Daten

| Feld | Name | Validierung |
|------|------|-------------|
| Vorname | `nombre0` | Pflichtfeld, darf nicht leer sein |
| Nachname | `apellidos0` | Pflichtfeld, darf nicht leer sein |
| Geburtsdatum | `birthdate0` | Pflichtfeld, spezielle Altersvalidierung in der Funktion `validateAge()` |
| DSB-Schu00fcler | `dsb0` | Pflichtfeld, mindestens eine Option muss ausgewu00e4hlt sein |
| Schule | `colegio0` | Pflichtfeld, darf nicht leer sein |
| Schwimmfu00e4higkeit | `nadar0` | Pflichtfeld, mindestens eine Option muss ausgewu00e4hlt sein |
| Erlaubnis Kinderbecken | `autohinch0` | Pflichtfeld, mindestens eine Option muss ausgewu00e4hlt sein |
| Erlaubnis grou00dfes Schwimmbecken | `autopisci0` | Pflichtfeld, mindestens eine Option muss ausgewu00e4hlt sein |
| Allergien | `alergias0` | Kein Pflichtfeld, keine spezielle Validierung |
| Lebensmittelunvertru00e4glichkeiten | `intolerancias0` | Kein Pflichtfeld, keine spezielle Validierung |
| Medikamente | `medicaciones0` | Kein Pflichtfeld, keine spezielle Validierung |

## Kurs-Optionen

| Feld | Name | Validierung |
|------|------|-------------|
| Sprache | `idioma0` | Pflichtfeld, mindestens eine Option muss ausgewu00e4hlt sein |
| Sprachniveau-Bemerkungen | `obsidioma0` | Pflichtfeld, darf nicht leer sein |
| Wochen | `curso0[]` | Pflichtfeld, mindestens eine Woche muss ausgewu00e4hlt sein |
| Fru00fchbetreuung | `fruehcurso0-X` | Kein Pflichtfeld, keine spezielle Validierung |
| Mittagsbetreuung | `mittagcurso0-X` | Kein Pflichtfeld, keine spezielle Validierung |

## Bus-Optionen

| Feld | Name | Validierung |
|------|------|-------------|
| Bus Hinfahrt | `Busida` | Pflichtfeld, darf nicht leer sein |
| Bus Ru00fcckfahrt | `Busvuelta` | Pflichtfeld, darf nicht leer sein |
| Bus Ru00fcckfahrt 16:15 | `Busvuelta2` | Pflichtfeld, darf nicht leer sein |

## Spezielle Validierungen

### Altersvalidierung

Die Funktion `validateAge()` pru00fcft das Alter des Schu00fclers und zeigt entsprechende Fehlermeldungen an:

- Pru00fcft, ob das Datum im Format YYYY-MM-DD eingegeben wurde
- Pru00fcft, ob das Alter zwischen 3 und 14 Jahren liegt
- Zeigt spezifische Fehlermeldungen fu00fcr zu junge oder zu alte Schu00fcler an

### Dynamische Validierungen

- Die Funktion `weekclick()` aktualisiert die Preisberechnung und zeigt/versteckt Optionen fu00fcr Fru00fch- und Mittagsbetreuung
- Die Funktion `dsbclicksi()` und `dsbclickno()` passen die Preisberechnung basierend auf dem DSB-Schu00fcler-Status an
- Die Funktion `idiomaclick()` verarbeitet die Sprachauswahl

### Formular-Absenden

Beim Absenden des Formulars wird die Funktion `submitclick()` aufgerufen, die alle Validierungen durchfu00fchrt und das Formular nur absendet, wenn alle Validierungen erfolgreich sind.
