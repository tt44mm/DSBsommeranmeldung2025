/**
 * Reine JavaScript-Funktionen für das Anmeldeformular
 * Ersetzt jQuery-Funktionen aus dem alten Formular
 */

// Frühe Anmeldung prüfen (Early Bird)
function isEarlyBird() {
    // Create a new Date object with the current date
    const currentDate = new Date();

    // Create a new Date object for June 1, 2025
    const juneFirst2025 = new Date('2025-06-01'); //2025-06-01 = 1.Juni 2025

    // Compare the two dates and return true if the current date is before June 1, 2025
    return currentDate < juneFirst2025;
}

// Animation-Hilfsfunktionen
function fadeIn(element) {
    if (!element) return;
    element.style.opacity = '0';
    element.style.display = '';
    setTimeout(function() {
        element.style.opacity = '1';
    }, 50);
}

function fadeOut(element) {
    if (!element) return;
    element.style.opacity = '1';
    setTimeout(function() {
        element.style.opacity = '0';
        element.style.display = 'none';
    }, 50);
}

function slideIn(element) {
    if (!element) return;
    element.style.opacity = '0';
    element.style.display = '';
    element.style.transform = 'translateX(100%)'; // Start off screen to the right
    setTimeout(function() {
        element.style.opacity = '1';
        element.style.transform = 'translateX(0)'; // Slide in to the left
    }, 50);
}

function slideOut(element) {
    if (!element) return;
    element.style.opacity = '0';
    element.style.transform = 'translateX(0)'; // Start from current position
    setTimeout(function() {
        element.style.opacity = '0';
        element.style.transform = 'translateX(100%)'; // Slide out to the right
    }, 50);
}

// Hauptfunktion für Wochenauswahl und Preisberechnung
function weekclick(indexstr) {
    // Formatierungsoptionen für Zahlen
    const options = {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    };

    // Hide/Unhide Mittag/Früh Optionen
    var parameterString = indexstr.toString().trim();
    var labmittagElement = document.getElementById('lab_mittagcurso0-' + parameterString);
    var labfruehElement = document.getElementById('lab_fruehcurso0-' + parameterString);
    var mittagElement = document.getElementById('mittagcurso0-' + parameterString);
    var fruehElement = document.getElementById('fruehcurso0-' + parameterString);
    var cursoElement = document.getElementById('curso0-' + parameterString);

    if (cursoElement && cursoElement.checked) {
        slideIn(labmittagElement);
        slideIn(labfruehElement);
    } else if (cursoElement) {
        slideOut(labmittagElement);
        slideOut(labfruehElement);
        
        // Uncheck die Options-Checkboxen, wenn die Woche abgewählt wird
        if (mittagElement) {
            mittagElement.checked = false;
        }
        if (fruehElement) {
            fruehElement.checked = false;
        }
    }

    // Preisberechnungen durchführen
    let week1, week2, week3, week4, week5, allweeks;
    let nodsb_week1, nodsb_week2, nodsb_week3, nodsb_week4, nodsb_week5, nodsb_allweeks;
    let vorjuni = isEarlyBird();
    let isDSBStudent = document.getElementById('dsb0_1') && document.getElementById('dsb0_1').checked;

    // Preise je nach Schülertyp und Early-Bird festlegen
    // Diese Werte müssen aus PHP dynamisch eingesetzt werden - hier nur als Platzhalter

    let descuentos = "";

    if (isDSBStudent) {
        descuentos = "alumno/a DSB ";
        if (vorjuni) {
            // Preise für DSB-Schüler mit Early-Bird Rabatt
            week1 = cursoprecio_1_2; // Diese Variablen müssen aus PHP kommen
            week2 = cursoprecio_2_2;
            week3 = cursoprecio_3_2;
            week4 = cursoprecio_4_2;
            week5 = cursoprecio_5_2;
            allweeks = cursoprecio_6_2;

            nodsb_week1 = cursoprecio_1_1;
            nodsb_week2 = cursoprecio_2_1;
            nodsb_week3 = cursoprecio_3_1;
            nodsb_week4 = cursoprecio_4_1;
            nodsb_week5 = cursoprecio_5_1;
            nodsb_allweeks = cursoprecio_1_1+cursoprecio_2_1+cursoprecio_3_1+cursoprecio_4_1+cursoprecio_5_1;

        } else {
            // Normale Preise für DSB-Schüler
            week1 = cursoprecio_1_4;
            week2 = cursoprecio_2_4;
            week3 = cursoprecio_3_4;
            week4 = cursoprecio_4_4;
            week5 = cursoprecio_5_4;
            allweeks = cursoprecio_6_4;

            nodsb_week1 = cursoprecio_1_3;
            nodsb_week2 = cursoprecio_2_3;
            nodsb_week3 = cursoprecio_3_3;
            nodsb_week4 = cursoprecio_4_3;
            nodsb_week5 = cursoprecio_5_3;
            nodsb_allweeks = cursoprecio_1_3 + cursoprecio_2_3 + cursoprecio_3_3 + cursoprecio_4_3 + cursoprecio_5_3;
        }
    } else {
        if (vorjuni) {
            // Preise für Nicht-DSB-Schüler mit Early-Bird Rabatt
            week1 = cursoprecio_1_1;
            week2 = cursoprecio_2_1;
            week3 = cursoprecio_3_1;
            week4 = cursoprecio_4_1;
            week5 = cursoprecio_5_1;
            allweeks = cursoprecio_6_1;
        } else {
            // Normale Preise für Nicht-DSB-Schüler
            week1 = cursoprecio_1_3;
            week2 = cursoprecio_2_3;
            week3 = cursoprecio_3_3;
            week4 = cursoprecio_4_3;
            week5 = cursoprecio_5_3;
            allweeks = cursoprecio_6_3;
        }
    }



    // Aktualisiere die Labels für die Wochen mit den korrekten Preisen
    const labWeek1 = document.getElementById('labweek1');
    const labWeek2 = document.getElementById('labweek2');
    const labWeek3 = document.getElementById('labweek3');
    const labWeek4 = document.getElementById('labweek4');
    const labWeek5 = document.getElementById('labweek5');

    if (labWeek1) labWeek1.innerHTML = weekLabel1 + week1 + '€)';
    if (labWeek2) labWeek2.innerHTML = weekLabel2 + week2 + '€)';
    if (labWeek3) labWeek3.innerHTML = weekLabel3 + week3 + '€)';
    if (labWeek4) labWeek4.innerHTML = weekLabel4 + week4 + '€)';
    if (labWeek5) labWeek5.innerHTML = weekLabel5 + week5 + '€)';

    // Optionspreise (bleiben gleich, unabhängig vom Schülertyp)
    const weekF1 = fruehcursoprecio_1;
    const weekF2 = fruehcursoprecio_2;
    const weekF3 = fruehcursoprecio_3;
    const weekF4 = fruehcursoprecio_4;
    const weekF5 = fruehcursoprecio_5;

    const weekM1 = mittagcursoprecio_1;
    const weekM2 = mittagcursoprecio_2;
    const weekM3 = mittagcursoprecio_3;
    const weekM4 = mittagcursoprecio_4;
    const weekM5 = mittagcursoprecio_5;

    // Berechne den Gesamtpreis
    let sumprecio = 0;
    let fullprice = 0;
    let nodsb_sumprecio = 0;

    // Addiere die Preise für die ausgewählten Wochen
    if (document.getElementById('curso0-1') && document.getElementById('curso0-1').checked) sumprecio += week1;
    if (document.getElementById('curso0-2') && document.getElementById('curso0-2').checked) sumprecio += week2;
    if (document.getElementById('curso0-3') && document.getElementById('curso0-3').checked) sumprecio += week3;
    if (document.getElementById('curso0-4') && document.getElementById('curso0-4').checked) sumprecio += week4;
    if (document.getElementById('curso0-5') && document.getElementById('curso0-5').checked) sumprecio += week5;

    if (isDSBStudent) {
        if (document.getElementById('curso0-1') && document.getElementById('curso0-1').checked) nodsb_sumprecio += nodsb_week1;
        if (document.getElementById('curso0-2') && document.getElementById('curso0-2').checked) nodsb_sumprecio += nodsb_week2;
        if (document.getElementById('curso0-3') && document.getElementById('curso0-3').checked) nodsb_sumprecio += nodsb_week3;
        if (document.getElementById('curso0-4') && document.getElementById('curso0-4').checked) nodsb_sumprecio += nodsb_week4;
        if (document.getElementById('curso0-5') && document.getElementById('curso0-5').checked) nodsb_sumprecio += nodsb_week5;
    }
    let dsbdifference = nodsb_sumprecio - sumprecio;

    // Rabatt für Auswahl aller Wochen
    const allWeeksSelected = 
        document.getElementById('curso0-1') && document.getElementById('curso0-1').checked &&
        document.getElementById('curso0-2') && document.getElementById('curso0-2').checked &&
        document.getElementById('curso0-3') && document.getElementById('curso0-3').checked &&
        document.getElementById('curso0-4') && document.getElementById('curso0-4').checked /* &&
        document.getElementById('curso0-5') && document.getElementById('curso0-5').checked*/;

    if (allWeeksSelected) {
        fullprice = sumprecio;
        sumprecio = allweeks;
        let descuentoall = "todos las semanas";
        if (isDSBStudent) {
            descuentos = descuentoall + ", " + descuentos;
        } else {
            descuentos = descuentoall;
        }
    } else {
        fullprice = sumprecio;
    }

    let difference=0;
    if (isDSBStudent) { 
        difference = nodsb_allweeks - allweeks;
    } else {
        difference = fullprice - sumprecio;
    }

    // Addiere die Preise für die ausgewählten Optionen
    if (document.getElementById('fruehcurso0-1') && document.getElementById('fruehcurso0-1').checked) sumprecio += weekF1;
    if (document.getElementById('fruehcurso0-2') && document.getElementById('fruehcurso0-2').checked) sumprecio += weekF2;
    if (document.getElementById('fruehcurso0-3') && document.getElementById('fruehcurso0-3').checked) sumprecio += weekF3;
    if (document.getElementById('fruehcurso0-4') && document.getElementById('fruehcurso0-4').checked) sumprecio += weekF4;
    if (document.getElementById('fruehcurso0-5') && document.getElementById('fruehcurso0-5').checked) sumprecio += weekF5;

    if (document.getElementById('mittagcurso0-1') && document.getElementById('mittagcurso0-1').checked) sumprecio += weekM1;
    if (document.getElementById('mittagcurso0-2') && document.getElementById('mittagcurso0-2').checked) sumprecio += weekM2;
    if (document.getElementById('mittagcurso0-3') && document.getElementById('mittagcurso0-3').checked) sumprecio += weekM3;
    if (document.getElementById('mittagcurso0-4') && document.getElementById('mittagcurso0-4').checked) sumprecio += weekM4;
    if (document.getElementById('mittagcurso0-5') && document.getElementById('mittagcurso0-5').checked) sumprecio += weekM5;

    // Formatiere den Preis
    const displayprice = sumprecio.toLocaleString('de-DE', options);
    const precioElement = document.getElementById('precio');

    if (difference > 0) {
        precioElement.innerHTML = displayprice + "€ (aplicados " + difference.toLocaleString('de-DE', options) + 
                         "€ de descuento por " + descuentos + ")" + 
                         '<br/> <a href="https://www.dsbilbao.org/cursos-de-idiomas/campus-de-verano/precios-matriculacion-pagos/" target="_new">Pol&iacute;tica de precios y descuentos</a>';
    } else {
        if (isDSBStudent) {
            precioElement.innerHTML = displayprice + "€ (precio de alumnos de DSB)";
        } else {
            precioElement.innerHTML = displayprice + "€";
        }
    } 


}

// DSB Schüler "Ja" geklickt
function dsbclicksi(indexstr) {
    const divlabelcolegio = document.getElementById('divlabelcolegio' + indexstr);
    const colegio = document.getElementById('colegio' + indexstr);
    
    if (divlabelcolegio) divlabelcolegio.style.display = 'none';
    if (colegio) colegio.value = "DSB";
    
    weekclick(1);
}

// DSB Schüler "Nein" geklickt
function dsbclickno(indexstr) {
    const divlabelcolegio = document.getElementById('divlabelcolegio' + indexstr);
    const colegio = document.getElementById('colegio' + indexstr);
    
    if (divlabelcolegio) divlabelcolegio.style.display = '';
    
    if (colegio && colegio.value === "DSB") {
        colegio.value = "";
    }
    
    weekclick(1);
}

// Klick auf das Colegio-Feld
function colegioclick(indexstr) {
    // Logik für Klick auf Colegio-Feld
    // Keine Aktion nötig, da keine jQuery-Funktionalität ersetzt werden muss
}

// Klick auf Idioma-Radio-Button
function idiomaclick(indexstr) {
    // Logik für Klick auf Idioma-Button
    // Keine Aktion nötig, da keine jQuery-Funktionalität ersetzt werden muss
}

// Validierungsfunktion für Postleitzahl (5 Ziffern)
function validatePLZ(input) {
    // Entferne zuerst alle vorhandenen Fehlermeldungen
    clearValidationError(input);
    
    const plzRegex = /^\d{5}$/;
    if (!plzRegex.test(input.value)) {
        showValidationError(input, 'Por favor, introduzca un código postal válido de 5 dígitos.');
        return false;
    }
    return true;
}

// Validierungsfunktion für Telefonnummern (Ziffern, Leerzeichen und + am Anfang)
function validatePhone(input) {
    // Entferne zuerst alle vorhandenen Fehlermeldungen
    clearValidationError(input);
    
    const phoneRegex = /^[+]?[0-9 ]+$/;
    if (!phoneRegex.test(input.value)) {
        showValidationError(input, 'Por favor, introduzca un número de teléfono válido (solo dígitos, espacios y + al principio).');
        return false;
    }
    return true;
}

// Validierung des gesamten Formulars beim Absenden
function submitclick(event) {
    console.log('===== FORMULARVALIDIERUNG GESTARTET =====');
    // Verhindere das Standard-Submit-Verhalten
    if (event) {
        event.preventDefault();
    }

    // Entferne alle Fehler
    const errorElements = document.querySelectorAll('.validationerror');
    errorElements.forEach(element => {
        if (element.parentNode) {
            element.parentNode.removeChild(element);
        }
    });

    // Validiere alle Pflichtfelder
    let isValid = true;
    let requiredValid = true;
    let formatValid = true;
    let specialValid = true;
    
    console.log('===== REQUIRED CHECK GESTARTET =====');
    // SCHRITT 1: Zuerst alle required-Felder auf Leerheit prüfen
    const requiredFields = document.querySelectorAll('.required');
    requiredFields.forEach(field => {
        // Spezielle Behandlung für Radio-Buttons
        if (field.type === 'radio') {
            const radioGroup = document.querySelectorAll('input[name="' + field.name + '"]');
            let anyChecked = false;
            
            radioGroup.forEach(radio => {
                if (radio.checked) {
                    anyChecked = true;
                }
            });
            
            const fieldResult = anyChecked;
            console.log(`Validierung REQUIRED für ${field.name} (Radio): ${fieldResult ? 'TRUE' : 'FALSE'}`);
            
            if (!fieldResult) {
                requiredValid = false;
                isValid = false;
                showValidationError(field, 'Este campo es obligatorio.');
            }
        }
        // Spezielle Behandlung für Checkboxen (Wochenauswahl)
        else if (field.name === 'curso0[]') {
            const checkboxGroup = document.querySelectorAll('input[name="curso0[]"]');
            let anyChecked = false;
            
            checkboxGroup.forEach(checkbox => {
                if (checkbox.checked) {
                    anyChecked = true;
                }
            });
            
            const fieldResult = anyChecked;
            console.log(`Validierung REQUIRED für ${field.name} (Checkbox): ${fieldResult ? 'TRUE' : 'FALSE'}`);
            
            if (!fieldResult) {
                requiredValid = false;
                isValid = false;
                showValidationError(field, 'Es necesario seleccionar al menos una semana.');
            }
        }
        // Behandlung für alle anderen Eingabefelder (text, textarea, tel, date, email, select)
        else if (field.type === 'text' || field.type === 'textarea' || field.type === 'tel' || 
                 field.type === 'date' || field.type === 'email' || field.type === 'select-one') {
            
            const fieldResult = field.value.trim() !== '';
            console.log(`Validierung REQUIRED für ${field.id}: ${fieldResult ? 'TRUE' : 'FALSE'}`);
            
            if (!fieldResult) {
                requiredValid = false;
                isValid = false;
                showValidationError(field, 'Este campo es obligatorio.');
            }
        }
    });
    
    console.log(`===== REQUIRED CHECK ERGEBNIS: ${requiredValid ? 'TRUE' : 'FALSE'} =====`);
    
    console.log('===== FORMAT CHECK GESTARTET =====');
    // SCHRITT 2: Dann spezielle Formatvalidierungen durchführen
    // PLZ validieren - Muss genau 5 Ziffern enthalten
    const plzField = document.getElementById('PLZ');
    if (plzField && plzField.value.trim()) { // Nur validieren, wenn nicht leer
        const plzRegex = /^\d{5}$/;
        const plzValue = plzField.value.trim();
        const isPlzValid = plzRegex.test(plzValue);
        
        console.log(`Validierung FORMAT für PLZ: ${isPlzValid ? 'TRUE' : 'FALSE'} (Wert: ${plzValue})`);
        
        if (!isPlzValid) {
            formatValid = false;
            isValid = false;
            showValidationError(plzField, 'Por favor, introduzca un código postal válido de 5 dígitos.');
        }
    }
    
    // Telefon validieren - Darf nur Ziffern, Leerzeichen und + am Anfang enthalten
    const phoneField = document.getElementById('Phone');
    if (phoneField && phoneField.value.trim()) { // Nur validieren, wenn nicht leer
        const phoneRegex = /^[+]?[0-9 ]+$/;
        const phoneValue = phoneField.value.trim();
        const isPhoneValid = phoneRegex.test(phoneValue);
        
        console.log(`Validierung FORMAT für Phone: ${isPhoneValid ? 'TRUE' : 'FALSE'} (Wert: ${phoneValue})`);
        
        if (!isPhoneValid) {
            formatValid = false;
            isValid = false;
            showValidationError(phoneField, 'Por favor, introduzca un número de teléfono válido (solo dígitos, espacios y + al principio).');
        }
    }
    
    // Zusätzliches Telefon validieren (falls vorhanden und nicht leer)
    const phone0Field = document.getElementById('phone0');
    if (phone0Field && phone0Field.value.trim()) { // Nur validieren, wenn nicht leer
        const phoneRegex = /^[+]?[0-9 ]+$/;
        const phoneValue = phone0Field.value.trim();
        const isPhoneValid = phoneRegex.test(phoneValue);
        
        console.log(`Validierung FORMAT für phone0: ${isPhoneValid ? 'TRUE' : 'FALSE'} (Wert: ${phoneValue})`);
        
        if (!isPhoneValid) {
            formatValid = false;
            isValid = false;
            showValidationError(phone0Field, 'Por favor, introduzca un número de teléfono válido (solo dígitos, espacios y + al principio).');
        }
    }
    
    console.log(`===== FORMAT CHECK ERGEBNIS: ${formatValid ? 'TRUE' : 'FALSE'} =====`);
    
    console.log('===== SPEZIAL CHECK GESTARTET =====');
    // SCHRITT 3: Spezielle Validierungen wie Alter und Email-Vergleich
    // Validiere das Geburtsdatum
    const birthdateField = document.getElementById('birthdate0');
    if (birthdateField) {
        // Immer validieren, unabhu00e4ngig davon, ob leer oder nicht
        // Wenn es leer ist, wird es bereits als erforderlich behandelt
        // Wenn es gefu00fcllt ist, muss das Alter validiert werden
        if (birthdateField.value.trim()) {
            const ageResult = validateAge(birthdateField);
            console.log(`Validierung SPEZIAL fu00fcr birthdate0 (Alter): ${ageResult ? 'TRUE' : 'FALSE'}`);
            
            if (!ageResult) {
                specialValid = false;
                isValid = false;
                // Fehlermeldung wird durch validateAge gesetzt
            }
        }
    }
    
    // Email-Vergleich validieren
    const email1Field = document.getElementById('Email1');
    const email2Field = document.getElementById('Email2');
    if (email1Field && email2Field && 
        email1Field.value.trim() && email2Field.value.trim()) {
        
        const emailsMatch = email1Field.value.trim() === email2Field.value.trim();
        console.log(`Validierung SPEZIAL für Email-Vergleich: ${emailsMatch ? 'TRUE' : 'FALSE'}`);
        
        if (!emailsMatch) {
            specialValid = false;
            isValid = false;
            showValidationError(email2Field, 'El correo electrónico repetido tiene que ser idéntico con el correo electrónico en el campo anterior');
        }
    }
    
    console.log(`===== SPEZIAL CHECK ERGEBNIS: ${specialValid ? 'TRUE' : 'FALSE'} =====`);
    
    // Zusammenfassung der Validierung ausgeben
    console.log(`===== VALIDIERUNGSGESAMTERGEBNIS: ${isValid ? 'TRUE' : 'FALSE'} =====`);
    console.log(`REQUIRED: ${requiredValid ? 'TRUE' : 'FALSE'} | FORMAT: ${formatValid ? 'TRUE' : 'FALSE'} | SPEZIAL: ${specialValid ? 'TRUE' : 'FALSE'}`);
    
    // Wenn alle Validierungen bestanden wurden, sende das Formular ab
    if (isValid) {
        console.log('Formular ist gültig');
        return true;
    } else {
        console.log('Formular ist ungültig');
        // Finde den ersten Fehler und scrolle dorthin
        const firstError = document.querySelector('.validationerror');
        if (firstError && firstError.previousElementSibling) {
            firstError.previousElementSibling.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return false;
    }
}

// Funktion zum Anzeigen von Validierungsfehlern
function showValidationError(field, message) {
    console.log('showValidationError aufgerufen für:', field.id, 'mit Nachricht:', message);
    // Zuerst alle vorhandenen Fehlermeldungen für dieses Feld entfernen
    clearValidationError(field);
    
    // Fehlermeldung erstellen
    const errorElement = document.createElement('div');
    errorElement.className = 'validationerror';
    errorElement.innerText = message;
    
    // Fehlermeldung direkt nach dem Eingabefeld einfügen
    const parent = field.parentNode;
    // Prüfen, ob bereits eine Fehlermeldung existiert
    const existingError = parent.querySelector('.validationerror');
    if (existingError) {
        console.log('Bestehende Fehlermeldung gefunden, wird entfernt');
        existingError.remove();
    }
    
    // Fehlermeldung nach dem Input-Feld einfügen
    console.log('Füge Fehlermeldung nach Feld ein:', field.id);
    field.insertAdjacentElement('afterend', errorElement);
    
    // Eingabefeld als fehlerhaft markieren
    field.classList.add('error');
    field.classList.remove('valid');
}

function clearValidationError(field) {
    // Entferne die Fehlerklasse vom Eingabefeld
    field.classList.remove('error');
    field.classList.add('valid');
    
    // Finde alle Fehlermeldungen im selben Container
    const parent = field.parentNode;
    const errors = parent.querySelectorAll('.validationerror');
    errors.forEach(error => error.remove());
}

// Funktion zur Altersvalidierung
function validateAge(input) {
    console.log('validateAge gestartet für:', input.id || input.name);
    
    // Entferne bestehende Fehler
    removeExistingError(input);
    
    // Überprüfe, ob ein Datum eingegeben wurde
    if (!input.value) {
        console.log('Kein Datum eingegeben');
        showAgeError(input, "Por favor, introduzca la fecha de nacimiento.");
        return false;
    }
    
    // Parse das eingegebene Datum
    const birthDate = new Date(input.value);
    console.log('Eingegebenes Datum:', birthDate);
    
    // Überprüfe, ob das Datum gültig ist
    if (isNaN(birthDate.getTime())) {
        console.log('Ungültiges Datum');
        showAgeError(input, "Por favor, introduzca una fecha válida.");
        return false;
    }
    
    // Berechne das Alter zum 1. Januar des aktuellen Jahres
    const today = new Date();
    const referenceDate = new Date(today.getFullYear(), 0, 1);
    let age = referenceDate.getFullYear() - birthDate.getFullYear();
    
    // Berücksichtige den Monat und Tag für die genaue Altersberechnung
    if (birthDate.getMonth() > referenceDate.getMonth() || 
        (birthDate.getMonth() === referenceDate.getMonth() && birthDate.getDate() > referenceDate.getDate())) {
        age--;
    }
    
    console.log('Berechnetes Alter:', age, 'Jahre');
    
    // Überprüfe, ob das Alter im gültigen Bereich liegt
    const isValidAge = age >= 2 && age <= 19;
    console.log('Ist Alter gültig (2-19 Jahre)?', isValidAge);
    
    if (!isValidAge) {
        const message = age < 2 ? 
            "El alumno/a es demasiado joven (debe tener al menos 2 años)." :
            "El alumno/a es demasiado mayor (debe tener menos de 19 años).";
        
        showAgeError(input, message);
        
        // Zeige JUNG/ALT Meldung
        const jungElement = document.getElementById('JUNG');
        const altElement = document.getElementById('ALT');
        
        if (age < 2) {
            if (jungElement) jungElement.style.display = 'block';
            if (altElement) altElement.style.display = 'none';
        } else {
            if (jungElement) jungElement.style.display = 'none';
            if (altElement) altElement.style.display = 'block';
        }
        
        return false;
    } else {
        // Verstecke JUNG/ALT Meldungen
        const jungElement = document.getElementById('JUNG');
        const altElement = document.getElementById('ALT');
        
        if (jungElement) jungElement.style.display = 'none';
        if (altElement) altElement.style.display = 'none';
        
        // Markiere als gültig
        input.classList.add('valid');
        input.classList.remove('error');
        
        return true;
    }
}

function removeExistingError(input) {
    // Entferne bestehende Fehlermeldung
    const existingError = input.parentElement.querySelector('.validationerror');
    if (existingError) {
        existingError.remove();
    }
}

function showAgeError(input, message) {
    // Markiere das Eingabefeld als ungültig
    input.classList.add('error');
    input.classList.remove('valid');
    
    // Erstelle und füge die Fehlermeldung hinzu
    const errorDiv = document.createElement('div');
    errorDiv.className = 'validationerror';
    errorDiv.style.display = 'block';
    errorDiv.style.visibility = 'visible';
    errorDiv.style.opacity = '1';
    errorDiv.setAttribute('data-for', 'birthdate0');
    
    const spanElement = document.createElement('span');
    spanElement.textContent = message;
    errorDiv.appendChild(spanElement);
    
    // Füge die Fehlermeldung nach dem Input-Feld ein
    input.parentElement.appendChild(errorDiv);
    
    // Stelle sicher, dass die Fehlermeldung sofort sichtbar ist
    setTimeout(() => {
        errorDiv.style.display = 'block';
        errorDiv.style.visibility = 'visible';
        errorDiv.style.opacity = '1';
    }, 0);
}

function hideAgeError(input) {
    // Entferne Fehlermarkierung vom Eingabefeld
    input.classList.remove('error');
    input.classList.add('valid');
    
    // Entferne die Fehlermeldung
    removeExistingError(input);
    
    // Verstecke JUNG/ALT Meldungen
    const jungElement = document.getElementById('JUNG');
    const altElement = document.getElementById('ALT');
    if (jungElement) jungElement.style.display = 'none';
    if (altElement) altElement.style.display = 'none';
}

// Diese Variablen werden dynamisch vom PHP-Code gefüllt
// Sie sind nur Platzhalter und müssen im PHP-Template gesetzt werden
let cursoprecio_1_1, cursoprecio_1_2, cursoprecio_1_3, cursoprecio_1_4;
let cursoprecio_2_1, cursoprecio_2_2, cursoprecio_2_3, cursoprecio_2_4;
let cursoprecio_3_1, cursoprecio_3_2, cursoprecio_3_3, cursoprecio_3_4;
let cursoprecio_4_1, cursoprecio_4_2, cursoprecio_4_3, cursoprecio_4_4;
let cursoprecio_5_1, cursoprecio_5_2, cursoprecio_5_3, cursoprecio_5_4;
let cursoprecio_6_1, cursoprecio_6_2, cursoprecio_6_3, cursoprecio_6_4;

let fruehcursoprecio_1, fruehcursoprecio_2, fruehcursoprecio_3, fruehcursoprecio_4, fruehcursoprecio_5;
let mittagcursoprecio_1, mittagcursoprecio_2, mittagcursoprecio_3, mittagcursoprecio_4, mittagcursoprecio_5;

let weekLabel1, weekLabel2, weekLabel3, weekLabel4, weekLabel5;

// Setze DOMContentLoaded Listener, um Initialisierungen nach dem Laden durchzuführen
document.addEventListener('DOMContentLoaded', function() {
    // Radio-Buttons für DSB-Frage initialisieren
    const dsb0_1 = document.getElementById('dsb0_1');
    const dsb0_2 = document.getElementById('dsb0_2');
    
    if (dsb0_1 && dsb0_1.checked) {
        dsbclicksi('0');
    } else if (dsb0_2 && dsb0_2.checked) {
        dsbclickno('0');
    }
    
    // Initialisiere die Wochenauswahl
    for (let weeknr = 1; weeknr <= 5; weeknr++) {
        const cursoElement = document.getElementById('curso0-' + weeknr);
        if (cursoElement && cursoElement.checked) {
            const elements = [
                { id: 'zoption0-' + weeknr + '-1' },
                { id: 'zoption0-' + weeknr + '-2' },
                { id: 'zoption0-' + weeknr + '-3' },
                { id: 'tdcurso-0-' + weeknr + '-0' },
                { id: 'tdoption-0-' + weeknr + '-1' },
                { id: 'tdoption-0-' + weeknr + '-2' },
                { id: 'tdoption-0-' + weeknr + '-3' }
            ];
            
            elements.forEach(elementInfo => {
                const element = document.getElementById(elementInfo.id);
                if (element) {
                    element.style.display = '';
                }
            });
        }
    }

    // Füge Form-Submit-Event-Listener hinzu
    const form = document.getElementById('formins');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!submitclick(event)) {
                event.preventDefault();
            }
        });
    }

    // Initialisiere Altersvalidierung
    const birthdateInput = document.getElementById('birthdate0');
    if (birthdateInput) {
        // Entferne eventuelle initiale Fehlermeldungen
        removeExistingError(birthdateInput);
        
        // Füge Blur-Event-Listener hinzu
        birthdateInput.addEventListener('blur', function() {
            validateAge(this);
        });
    }

    // Event-Listener für die Validierung beim Laden der Seite hinzufügen
    const plzField = document.getElementById('PLZ');
    if (plzField) {
        plzField.addEventListener('input', function() {
            const plzRegex = /^\d{5}$/;
            if (!plzRegex.test(this.value)) {
                showValidationError(this, 'Por favor, introduzca un código postal válido de 5 dígitos.');
            } else {
                clearValidationError(this);
            }
        });
        plzField.addEventListener('blur', function() {
            const plzRegex = /^\d{5}$/;
            if (!plzRegex.test(this.value)) {
                showValidationError(this, 'Por favor, introduzca un código postal válido de 5 dígitos.');
            } else {
                clearValidationError(this);
            }
        });
    }

    // Telefon-Validierung
    const phoneField = document.getElementById('Phone');
    if (phoneField) {
        phoneField.addEventListener('input', function() {
            const phoneRegex = /^[+]?[0-9 ]+$/;
            if (!phoneRegex.test(this.value)) {
                showValidationError(this, 'Por favor, introduzca un número de teléfono válido (solo dígitos, espacios y + al principio).');
            } else {
                clearValidationError(this);
            }
        });
        phoneField.addEventListener('blur', function() {
            const phoneRegex = /^[+]?[0-9 ]+$/;
            if (!phoneRegex.test(this.value)) {
                showValidationError(this, 'Por favor, introduzca un número de teléfono válido (solo dígitos, espacios y + al principio).');
            } else {
                clearValidationError(this);
            }
        });
    }

    // Zusatztelefon-Validierung (nur wenn ein Wert eingegeben wurde)
    const phone0Field = document.getElementById('phone0');
    if (phone0Field) {
        phone0Field.addEventListener('input', function() {
            if (this.value.trim()) {
                const phoneRegex = /^[+]?[0-9 ]+$/;
                if (!phoneRegex.test(this.value)) {
                    showValidationError(this, 'Por favor, introduzca un número de teléfono válido (solo dígitos, espacios y + al principio).');
                } else {
                    clearValidationError(this);
                }
            } else {
                clearValidationError(this);
            }
        });
        phone0Field.addEventListener('blur', function() {
            if (this.value.trim()) {
                const phoneRegex = /^[+]?[0-9 ]+$/;
                if (!phoneRegex.test(this.value)) {
                    showValidationError(this, 'Por favor, introduzca un número de teléfono válido (solo dígitos, espacios y + al principio).');
                } else {
                    clearValidationError(this);
                }
            } else {
                clearValidationError(this);
            }
        });
    }
});