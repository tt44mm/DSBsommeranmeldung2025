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
    let vorjuni = isEarlyBird();
    let isDSBStudent = document.getElementById('dsb0_1') && document.getElementById('dsb0_1').checked;

    // Preise je nach Schülertyp und Early-Bird festlegen
    // Diese Werte müssen aus PHP dynamisch eingesetzt werden - hier nur als Platzhalter
    if (isDSBStudent) {
        if (vorjuni) {
            // Preise für DSB-Schüler mit Early-Bird Rabatt
            week1 = cursoprecio_1_2; // Diese Variablen müssen aus PHP kommen
            week2 = cursoprecio_2_2;
            week3 = cursoprecio_3_2;
            week4 = cursoprecio_4_2;
            week5 = cursoprecio_5_2;
            allweeks = cursoprecio_6_2;
        } else {
            // Normale Preise für DSB-Schüler
            week1 = cursoprecio_1_4;
            week2 = cursoprecio_2_4;
            week3 = cursoprecio_3_4;
            week4 = cursoprecio_4_4;
            week5 = cursoprecio_5_4;
            allweeks = cursoprecio_6_4;
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
    let descuentos = "";

    // Addiere die Preise für die ausgewählten Wochen
    if (document.getElementById('curso0-1') && document.getElementById('curso0-1').checked) sumprecio += week1;
    if (document.getElementById('curso0-2') && document.getElementById('curso0-2').checked) sumprecio += week2;
    if (document.getElementById('curso0-3') && document.getElementById('curso0-3').checked) sumprecio += week3;
    if (document.getElementById('curso0-4') && document.getElementById('curso0-4').checked) sumprecio += week4;
    if (document.getElementById('curso0-5') && document.getElementById('curso0-5').checked) sumprecio += week5;

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
    } else {
        fullprice = sumprecio;
    }

    const difference = fullprice - sumprecio;

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
        precioElement.innerHTML = displayprice + "€";
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

// Validierung des gesamten Formulars beim Absenden
function submitclick(event) {
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
    const requiredFields = document.querySelectorAll('.required');
    
    requiredFields.forEach(field => {
        // Spezielle Behandlung für das Geburtsdatum
        if (field.id === 'birthdate0') {
            const birthdateValid = validateAge(field);
            if (!birthdateValid) {
                isValid = false;
                // Stelle sicher, dass die Fehlermeldung sofort sichtbar ist
                const errorElement = field.parentElement.querySelector('.validationerror');
                if (errorElement) {
                    errorElement.style.display = 'block';
                    errorElement.style.visibility = 'visible';
                    errorElement.style.opacity = '1';
                }
                field.classList.add('error');
                field.classList.remove('valid');
            }
            return;
        }
        
        // Spezielle Behandlung für Radio-Buttons
        if (field.type === 'radio') {
            const radioGroup = document.querySelectorAll('input[name="' + field.name + '"]');
            let anyChecked = false;
            
            radioGroup.forEach(radio => {
                if (radio.checked) {
                    anyChecked = true;
                }
            });
            
            if (!anyChecked) {
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
            
            if (!anyChecked) {
                isValid = false;
                showValidationError(field, 'Es necesario seleccionar al menos una semana.');
            }
        }
        // Behandlung für normale Textfelder
        else if (field.type === 'text' || field.type === 'textarea' || field.type === 'email' || field.type === 'date') {
            if (!field.value.trim()) {
                isValid = false;
                showValidationError(field, 'Este campo es obligatorio.');
            }
            // E-Mail-Validierung
            else if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
                isValid = false;
                showValidationError(field, 'Por favor, introduzca una dirección de correo electrónico válida.');
            }
            // Prüfe, ob E-Mail-Felder übereinstimmen
            else if (field.id === 'Email2' && field.value !== document.getElementById('Email1').value) {
                isValid = false;
                showValidationError(field, 'El correo electrónico repetido tiene que ser identico con el correo electrónico en el campo anterior');
            }
        }
    });

    // Wenn das Formular gültig ist, können wir es absenden
    if (isValid) {
        document.getElementById('anmeldungsform').submit();
    }

    return isValid;
}

// Hilfsfunktion zur Anzeige von Validierungsfehlern
function showValidationError(field, message) {
    // Erstelle Fehlermeldungs-Container
    const errorElement = document.createElement('div');
    errorElement.className = 'validationerror';
    errorElement.innerHTML = '<span>' + message + '</span>';
    
    // Füge die Fehlermeldung ein
    const formRow = field.closest('.form-row');
    if (formRow) {
        formRow.appendChild(errorElement);
    } else {
        const parent = field.parentNode;
        if (parent) {
            parent.appendChild(errorElement);
        }
    }
    
    // Markiere das Feld visuell als ungültig
    field.classList.add('error');
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

// Funktion zur Altersvalidierung
function validateAge(input) {
    // Entferne bestehende Fehlermeldungen
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
    
    console.log('Berechnetes Alter:', age);
    
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
        
        // Stelle sicher, dass die Fehlermarkierung und -meldung sofort sichtbar sind
        input.classList.add('error');
        input.classList.remove('valid');
        const errorElement = input.parentElement.querySelector('.validationerror');
        if (errorElement) {
            errorElement.style.display = 'block';
            errorElement.style.visibility = 'visible';
            errorElement.style.opacity = '1';
        }
        return false;
    }
    
    // Wenn alles gültig ist
    hideAgeError(input);
    input.classList.remove('error');
    input.classList.add('valid');
    return true;
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
    const form = document.getElementById('anmeldungsform');
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
}); 