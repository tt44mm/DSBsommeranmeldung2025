/**
 * Reine JavaScript-Funktionen für das Anmeldeformular
 * Ersetzt jQuery-Funktionen aus dem alten Formular
 * 
 * ZUSAMMENSPIEL MIT ANDEREN DATEIEN:
 * - Diese Datei: UI-Funktionen und einfache Feld-Validierungen
 * - pure-validation.js: Komplexes Formular-Validierungssystem
 *
 * EXPORTIERTE FUNKTIONEN:
 * Diese Funktionen werden global (window) exportiert und von pure-validation.js verwendet:
 * - validatePLZ: Validiert Postleitzahlen
 * - validatePhone: Validiert Telefonnummern
 * - validateAge: Validiert das Alter anhand des Geburtsdatums
 * - createErrorElement: Basisfunktion für die Erstellung von Fehlermeldungen
 * - removeErrorElement: Basisfunktion für das Entfernen von Fehlermeldungen
 *
 * HINWEIS ZUR FUNKTIONSAUFTEILUNG:
 * Einige Validierungsfunktionen (validatePLZ, validatePhone, validateAge)
 * sind hier implementiert, während ähnliche Funktionalität auch in 
 * pure-validation.js über das validationRules-Objekt verfügbar ist.
 * Diese Aufteilung resultiert aus der schrittweisen Migration von jQuery.
 */

/**
 * Funktionsübersicht (25.03.2025):
 * - isEarlyBird(): Prüft, ob das aktuelle Datum vor dem 1. Juni 2025 liegt (Early-Bird-Rabatt)
 * - slideIn(element): Animation zum Einblenden und von rechts Einschieben eines Elements
 * - slideOut(element): Animation zum Ausblenden und nach rechts Ausschieben eines Elements
 * - weekclick(indexstr): Hauptfunktion für Wochenauswahl und Preisberechnung
 * - dsbclicksi(indexstr): Wird aufgerufen, wenn "Ja" bei DSB-Schüler ausgewählt wird
 * - dsbclickno(indexstr): Wird aufgerufen, wenn "Nein" bei DSB-Schüler ausgewählt wird
 * - validatePLZ(input): Validiert die Postleitzahl auf 5 Ziffern
 * - validatePhone(input): Validiert Telefonnummern auf gültiges Format
 * - showValidationError(field, message): Zeigt Validierungsfehler für ein Feld an
 * - clearValidationError(field): Entfernt Validierungsfehler für ein Feld
 * - validateAge(input): Prüft, ob das eingegebene Alter im gültigen Bereich liegt (2-19 Jahre)
 * - removeExistingError(input): Entfernt vorhandene Fehlermeldungen bei der Altersvalidierung
 * - showAgeError(input, message): Zeigt spezifische Altersfehler mit besonderen Meldungen an
 * - hideAgeError(input): Entfernt Altersfehlermeldungen
 * - handlePoolQuestionVisibility(input): Prüft ob das Kind älter als 6 Jahre ist und blendet ggf. die Pool-Frage aus
 */

// ===== ALLGEMEINE HILFSFUNKTIONEN =====

/**
 * Prüft, ob das aktuelle Datum vor dem 1. Juni 2025 liegt (Early-Bird-Rabatt)
 * 
 * Wird aufgerufen in der Preisberechnung, um Early-Bird-Rabatte zu gewähren
 */
function isEarlyBird() {
    // Create a new Date object with the current date
    const currentDate = new Date();

    // Create a new Date object for June 1, 2025
    const juneFirst2025 = new Date('2025-06-01'); //2025-06-01 = 1.Juni 2025

    // Compare the two dates and return true if the current date is before June 1, 2025
    return currentDate < juneFirst2025;
}

// Animation-Hilfsfunktionen
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
    let difference=0;


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
    difference = dsbdifference;
            
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
        let descuentoall = "todas las semanas";
        if (isDSBStudent) {
            descuentos = descuentoall + ", " + descuentos;
        } else {
            descuentos = descuentoall;
        }
        if (isDSBStudent) { 
            dsbdifference = nodsb_allweeks - allweeks;
        } 
    } else {
        fullprice = sumprecio;
    }

    difference = fullprice - sumprecio;

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

    if (difference > 0 || dsbdifference > 0) {
        if (isDSBStudent) {
            precioElement.innerHTML = displayprice + "€ (aplicados " + dsbdifference.toLocaleString('de-DE', options) + 
                            "€ de descuento por " + descuentos + ")" + 
                            '<br/> <a href="https://www.dsbilbao.org/cursos-de-idiomas/campus-de-verano/precios-matriculacion-pagos/" target="_new">Política de precios y descuentos</a>';
        } else {
            precioElement.innerHTML = displayprice + "€ (aplicados " + difference.toLocaleString('de-DE', options) + 
                            "€ de descuento por " + descuentos + ")" + 
                            '<br/> <a href="https://www.dsbilbao.org/cursos-de-idiomas/campus-de-verano/precios-matriculacion-pagos/" target="_new">Política de precios y descuentos</a>';
        }

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

/**
 * Validiert Postleitzahlen auf genau 5 Ziffern
 * Wird bei Eingabe und beim Verlassen des PLZ-Feldes sowie beim Formular-Submit aufgerufen
 * 
 * @param {HTMLInputElement} input - Das PLZ-Eingabefeld
 * @returns {boolean} True wenn die PLZ gültig ist, sonst false
 */
function validatePLZ(input) {
    // Entferne zuerst alle vorhandenen Fehlermeldungen
    clearValidationError(input);
    
    // Prüfe, ob die Eingabe genau 5 Ziffern enthält
    const regex = /^\d{5}$/;
    if (input.value.trim() !== '' && !regex.test(input.value.trim())) {
        showValidationError(input, 'Por favor, introduzca un código postal válido de 5 dígitos.');
        return false;
    }
    return true;
}

/**
 * Validiert Telefonnummern auf gültiges Format (nur Ziffern, Leerzeichen und + am Anfang)
 * Wird bei Eingabe und beim Verlassen der Telefonfelder sowie beim Formular-Submit aufgerufen
 * 
 * @param {HTMLInputElement} input - Das Telefon-Eingabefeld
 * @returns {boolean} True wenn die Telefonnummer gültig ist, sonst false
 */
function validatePhone(input) {
    // Entferne zuerst alle vorhandenen Fehlermeldungen
    clearValidationError(input);
    
    // Prüfe, ob die Eingabe nur Ziffern, Leerzeichen und ein + am Anfang enthält
    const regex = /^[+]?[0-9 ]+$/;
    if (input.value.trim() !== '' && !regex.test(input.value.trim())) {
        showValidationError(input, 'Por favor, introduzca un número de teléfono válido (solo dígitos, espacios y + al principio).');
        return false;
    }
    return true;
}

/**
 * Erstellt ein DOM-Element für Validierungsfehlermeldungen
 * Diese Funktion ist eine gemeinsame Basisfunktion für verschiedene Fehleranzeigefunktionen
 * 
 * @param {string} message - Die anzuzeigende Fehlermeldung
 * @param {string} fieldId - Die ID oder der Name des Feldes, auf das sich die Fehlermeldung bezieht
 * @returns {HTMLElement} Das erstellte Fehlermeldungselement
 */
function createErrorElement(message, fieldId) {
    // Erstelle ein neues Element für die Fehlermeldung
    const errorElement = document.createElement('div');
    errorElement.className = 'validationerror';
    errorElement.style.display = 'block';
    errorElement.style.visibility = 'visible';
    errorElement.style.opacity = '1';
    
    // Setze ein Datenattribut für die Zuordnung zum Feld
    if (fieldId) {
        errorElement.setAttribute('data-for', fieldId);
    }
    
    // Erstelle und füge den Nachrichtentext hinzu
    const spanElement = document.createElement('span');
    spanElement.textContent = message;
    errorElement.appendChild(spanElement);
    
    return errorElement;
}

/**
 * Zeigt Validierungsfehler für ein Formularfeld an
 * Wird von verschiedenen Validierungsfunktionen aufgerufen, um Fehlermeldungen anzuzeigen
 * 
 * @param {HTMLElement} field - Das Feld mit Validierungsfehler
 * @param {string} message - Die anzuzeigende Fehlermeldung
 */
function showValidationError(field, message) {
    console.log('showValidationError aufgerufen für:', field.id, 'mit Nachricht:', message);
    
    // Prüfe zunächst, ob schon eine Fehlermeldung existiert
    const existingError = field.parentNode.querySelector('.validationerror');
    if (existingError) {
        existingError.textContent = message;
        return;
    }
    
    // Verwende die gemeinsame Basisfunktion für die Fehlererstellung
    const errorElement = createErrorElement(message, field.id || field.name);
    errorElement.style.color = 'red';
    errorElement.style.fontSize = '0.8em';
    errorElement.style.marginTop = '5px';
    
    // Füge die Fehlermeldung nach dem Feld ein
    field.parentNode.appendChild(errorElement);
    
    // Setze eine visuelle Markierung am Feld
    field.classList.add('validationinvalid');
    field.style.borderColor = 'red';
    
    // Hinzufügen der 'error'-Klasse für die Kompatibilität mit pure-validation.js
    field.classList.add('error');
    
    // Entfernen der 'valid'-Klasse falls sie vorhanden ist
    field.classList.remove('valid');
    
    console.log('Neue Fehlermeldung hinzugefügt');
}

/**
 * Entfernt Fehlermeldungselemente für ein bestimmtes Feld
 * Gemeinsame Basisfunktion für das Entfernen von Validierungsfehlern
 * 
 * @param {string} selector - CSS-Selektor für die zu entfernenden Fehlerelemente
 */
function removeErrorElement(selector) {
    // Finde alle Fehlermeldungen, die dem Selektor entsprechen
    const errorMessages = document.querySelectorAll(selector);
    
    // Entferne jede gefundene Fehlermeldung
    errorMessages.forEach(function(element) {
        if (element && element.parentElement) {
            element.parentElement.removeChild(element);
        }
    });
}

/**
 * Entfernt Validierungsfehler für ein bestimmtes Feld
 * Wird aufgerufen, bevor eine neue Validierung durchgeführt wird
 * 
 * @param {HTMLElement} field - Das Feld, für das Fehler entfernt werden sollen
 */
function clearValidationError(field) {
    // Erstelle einen Selektor basierend auf der Feld-ID oder dem Namen
    const selector = field.id ? 
        `.validationerror[data-for="${field.id}"]` : 
        `.validationerror[data-for="${field.name}"]`;
    
    // Verwende die gemeinsame Basisfunktion zum Entfernen der Fehler
    removeErrorElement(selector);
    
    // Entferne auch visuelle Kennzeichnungen vom Feld selbst
    field.classList.remove('validationinvalid');
    field.classList.remove('error');
    field.style.borderColor = '';
}

/**
 * Validiert das Alter anhand des Geburtsdatums
 * Prüft, ob das berechnete Alter zwischen 2 und 19 Jahren liegt
 * Wird beim Verlassen des Geburtsdatumsfeldes und beim Formular-Submit aufgerufen
 * 
 * @param {HTMLInputElement} input - Das Geburtsdatum-Eingabefeld
 * @returns {boolean} True wenn das Alter im gültigen Bereich liegt, sonst false
 */
function validateAge(input) {
    console.log('Altersvalidierung gestartet für Feld:', input.id);
    
    // Entferne vorhandene Fehlermeldungen
    removeExistingError(input);
    
    // Prüfe, ob ein Datum eingegeben wurde
    if (!input.value) {
        return true; // Leeres Feld ist okay, wird durch required-Validierung abgedeckt
    }
    
    // Umwandlung des eingegebenen Datums in ein Date-Objekt
    const birthDate = new Date(input.value);
    
    // Prüfe, ob das Datum gültig ist
    if (isNaN(birthDate.getTime())) {
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
    const isValidAge = age >= 1 && age <= 85;
    console.log('Ist Alter gültig (2-85 Jahre)?', isValidAge);
    
    if (!isValidAge) {
        const message = age < 1 ? 
            "El/la alumno/a es demasiado joven (debe tener al menos 2 años el 31 de diciembre de este año)." :
            "El/la alumno/a es demasiado mayor (debe tener menos de 85 años).";
        
        showAgeError(input, message);
        
        // Zeige JUNG/ALT Meldung
        const jungElement = document.getElementById('JUNG');
        const altElement = document.getElementById('ALT');
        
        if (age < 1) {
            if (jungElement) jungElement.style.display = 'inline';
            if (altElement) altElement.style.display = 'none';
        } else {
            if (jungElement) jungElement.style.display = 'none';
            if (altElement) altElement.style.display = 'inline';
        }
        
        return false;
    } else {
        // Verstecke JUNG/ALT Meldungen
        const jungElement = document.getElementById('JUNG');
        const altElement = document.getElementById('ALT');
        
        if (jungElement) jungElement.style.display = 'none';
        if (altElement) altElement.style.display = 'none';
        
        hideAgeError(input);
        return true;
    }
}

function removeExistingError(input) {
    // Erstelle einen Selektor für die Fehlermeldung des Geburtstagfeldes
    const selector = '.validationerror[data-for="birthdate0"]';
    
    // Verwende die gemeinsame Basisfunktion zum Entfernen der Fehler
    removeErrorElement(selector);
}

function showAgeError(input, message) {
    // Markiere das Eingabefeld als ungültig
    input.classList.add('error');
    input.classList.remove('valid');
    
    // Verwende die gemeinsame Basisfunktion für die Fehlererstellung
    const errorDiv = createErrorElement(message, 'birthdate0');
    
    // Füge die Fehlermeldung nach dem Input-Feld ein
    input.parentElement.appendChild(errorDiv);
    
    // Stelle sicher, dass die Fehlermeldung sofort sichtbar ist
    setTimeout(() => {
        errorDiv.style.display = 'block';
        errorDiv.style.visibility = 'visible';
        errorDiv.style.opacity = '1';
    }, 0);
}

/**
 * Entfernt die Fehlermeldung für das Altersvalidierungsfeld
 * @param {HTMLElement} input - Das Eingabefeld für das Geburtsdatum
 */
function hideAgeError(input) {
    // Entferne Fehlermarkierung vom Eingabefeld
    input.classList.remove('error');
    input.classList.add('valid');
    
    // Verwende die gemeinsame Basisfunktion zum Entfernen der Fehler
    // anstelle des bisherigen direkten Aufrufs von removeExistingError
    removeErrorElement('.validationerror[data-for="birthdate0"]');
    
    // Verstecke JUNG/ALT Meldungen
    const jungElement = document.getElementById('JUNG');
    const altElement = document.getElementById('ALT');
    if (jungElement) jungElement.style.display = 'none';
    if (altElement) altElement.style.display = 'none';
}

/**
 * Prüft ob das Kind älter als 6 Jahre ist und blendet ggf. die Pool-Frage aus
 * Bei Kindern über 6 Jahren wird die Pool-Frage automatisch auf "Ja" gesetzt
 * 
 * @param {HTMLInputElement} input - Das Geburtsdatum-Eingabefeld
 */
function handlePoolQuestionVisibility(input) {
    console.log('Überprüfe Alter für Pool-Frage-Sichtbarkeit');
    
    // Hole die aktuellen DOM-Elemente
    const poolQuestionContainer = document.querySelector('.form-row:has(#autohinch0_1)') || 
                                 document.querySelector('div.form-row:has([name="autohinch0"])');
    const poolYesRadio = document.getElementById('autohinch0_1');
    const poolNoRadio = document.getElementById('autohinch0_2');
    
    if (!poolQuestionContainer || !poolYesRadio || !poolNoRadio) {
        console.error('Pool-Frage-Elemente nicht gefunden');
        return;
    }
    
    // Wenn kein Datum eingegeben wurde, zeige die Frage an
    if (!input.value) {
        poolQuestionContainer.style.display = '';
        return;
    }
    
    try {
        // Parse das eingegebene Datum
        const birthDate = new Date(input.value);
        if (isNaN(birthDate.getTime())) {
            poolQuestionContainer.style.display = '';
            return;
        }
        
        // Berechne das Alter am 1.1. des aktuellen Jahres
        const currentYear = new Date().getFullYear();
        const referenceDate = new Date(currentYear, 0, 1); // 1. Januar des aktuellen Jahres
        
        // Berechne das Alter in Jahren
        let age = referenceDate.getFullYear() - birthDate.getFullYear();
        
        // Prüfe, ob der Geburtstag in diesem Jahr schon war
        const hasBirthdayOccurred = (
            referenceDate.getMonth() > birthDate.getMonth() || 
            (referenceDate.getMonth() === birthDate.getMonth() && 
             referenceDate.getDate() >= birthDate.getDate())
        );
        
        if (!hasBirthdayOccurred) {
            age--;
        }
        
        console.log('Berechnetes Alter am 1.1.:', age);
        
        // Verstecke die Frage und setze "Ja" automatisch, wenn das Kind älter als 6 Jahre ist
        if (age > 6) {
            poolQuestionContainer.style.display = 'none';
            poolYesRadio.checked = true;
            
            // Löse ein change-Event aus, falls nötig
            const event = new Event('change', { bubbles: true });
            poolYesRadio.dispatchEvent(event);
            
            console.log('Kind ist älter als 6 Jahre - Pool-Frage ausgeblendet und auf "Ja" gesetzt');
        } else {
            // Zeige die Frage für Kinder bis 6 Jahre
            poolQuestionContainer.style.display = '';
            console.log('Kind ist 6 Jahre oder jünger - Pool-Frage wird angezeigt');
        }
    } catch (e) {
        console.error('Fehler bei der Altersberechnung für Pool-Frage:', e);
        poolQuestionContainer.style.display = '';
    }
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
    
    if (dsb0_1) {
        dsb0_1.addEventListener('change', function() {
            if (this.checked) dsbclicksi('0');
        });
    }
    
    if (dsb0_2) {
        dsb0_2.addEventListener('change', function() {
            if (this.checked) dsbclickno('0');
        });
    }
    
    // Event-Listener für Wochen-Checkboxen
    for (let i = 1; i <= 5; i++) {
        const cursoElement = document.getElementById('curso0-' + i);
        if (cursoElement) {
            cursoElement.addEventListener('change', function() {
                weekclick(i);
            });
        }
    }
    
    // Event-Listener für Mittag- und Früh-Optionen
    for (let i = 1; i <= 5; i++) {
        const mittagElement = document.getElementById('mittagcurso0-' + i);
        const fruehElement = document.getElementById('fruehcurso0-' + i);
        
        if (mittagElement) {
            mittagElement.addEventListener('change', function() {
                weekclick(i); // Aktualisiere Preise, wenn Mittag-Option geändert wird
            });
        }
        
        if (fruehElement) {
            fruehElement.addEventListener('change', function() {
                weekclick(i); // Aktualisiere Preise, wenn Früh-Option geändert wird
            });
        }
    }
    
    // NEU: Event-Listener für Geburtsdatum-Feld zur Pool-Frage-Sichtbarkeit
    const birthdateInput = document.getElementById('birthdate0');
    if (birthdateInput) {
        // Bei Änderung des Geburtsdatums
        birthdateInput.addEventListener('change', function() {
            handlePoolQuestionVisibility(this);
        });
        
        // Initialen Status direkt beim Laden setzen, falls ein Wert vorhanden ist
        handlePoolQuestionVisibility(birthdateInput);
    }
    
    // Die Event-Listener für die Validierungsfunktionen wurden entfernt,
    // da diese jetzt von pure-validation.js verwaltet werden.
    // Die Validierungsfunktionen selbst bleiben unverändert.
    
    // Initialisiere Preisanzeige
    weekclick('1');
});