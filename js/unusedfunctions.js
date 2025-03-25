/**
 * Ungenutzte Funktionen aus dem Anmeldeformular
 * Diese Funktionen werden derzeit nicht im Projekt verwendet, werden aber für zukünftige Referenz aufbewahrt
 */

// Klick auf das Colegio-Feld
function colegioclick(indexstr) {
    var dsb0_1 = document.getElementById('dsb0_1');
    var colegio0 = document.getElementById('colegio0');
    if (dsb0_1 && dsb0_1.checked) {
        colegio0.disabled = false;
    }
}

// Klick auf Idioma-Radio-Button
function idiomaclick(indexstr) {
    // Diese Funktion scheint leer zu sein
    // Hier könnte zukünftig Code für die Auswahl des Idioma-Radio-Buttons implementiert werden
}

// Validierung des gesamten Formulars beim Absenden
// Ursprünglich aus js-functions.js
function submitclick(event) {
    // Verhindere standardmäßiges Formular-Absenden
    if (event) {
        event.preventDefault();
    }
    
    // Leere das Feld für Validierungsfehler
    const errorField = document.getElementById('errorfield');
    if (errorField) {
        errorField.innerHTML = '';
        errorField.style.display = 'none';
    }

    // Sammle alle Formularfelder
    let isValid = true;
    const errors = [];
    const fields = document.querySelectorAll('#formins input, #formins select, #formins textarea');

    // Überprüfe jedes Feld
    fields.forEach(function(field) {
        // Überspringe nicht-required Felder oder versteckte Felder
        if (!field.classList.contains('required') || field.type === 'hidden') {
            return;
        }

        // Entferne bestehende Fehlermarkierungen
        clearValidationError(field);

        // Validiere basierend auf Feldtyp
        if (field.type === 'checkbox') {
            // Für einzelne Checkboxen: Muss angekreuzt sein, wenn required
            if (!field.checked) {
                showValidationError(field, 'Este campo es obligatorio');
                isValid = false;
                errors.push('Checkbox: ' + (field.id || 'unnamed'));
            }
        } 
        else if (field.type === 'radio') {
            // Für Radio-Buttons: Mindestens einer aus der Gruppe muss ausgewählt sein
            const radioGroup = document.querySelectorAll('input[name="' + field.name + '"]');
            let isChecked = false;
            
            radioGroup.forEach(function(radio) {
                if (radio.checked) {
                    isChecked = true;
                }
            });
            
            if (!isChecked) {
                // Nur einmal pro Gruppe einen Fehler anzeigen
                if (!field.dataset.errorShown) {
                    showValidationError(field, 'Seleccione una opción');
                    field.dataset.errorShown = 'true';
                    isValid = false;
                    errors.push('Radio: ' + field.name);
                }
            }
        }
        // Email-Validierung
        else if (field.type === 'email') {
            if (!field.value.trim()) {
                showValidationError(field, 'Introduzca su correo electrónico');
                isValid = false;
                errors.push('Email vacío: ' + field.id);
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
                showValidationError(field, 'Correo electrónico no válido');
                isValid = false;
                errors.push('Email inválido: ' + field.id);
            }
            
            // Zusätzliche Validierung für Email2 (muss mit Email1 übereinstimmen)
            if (field.id === 'Email2') {
                const email1 = document.getElementById('Email1');
                if (email1 && field.value !== email1.value) {
                    showValidationError(field, 'Los correos electrónicos no coinciden');
                    isValid = false;
                    errors.push('Emails no coinciden');
                }
            }
        }
        // Für alle anderen Feldtypen: Einfache Leerprüfung
        else if (!field.value.trim()) {
            showValidationError(field, 'Este campo es obligatorio');
            isValid = false;
            errors.push('Campo vacío: ' + field.id);
        }
    });

    // Spezielle Validierung für Wochenauswahl (mindestens eine Woche muss ausgewählt sein)
    const weeks = document.querySelectorAll('input[name="curso0[]"]');
    let weekSelected = false;
    
    weeks.forEach(function(week) {
        if (week.checked) {
            weekSelected = true;
        }
    });
    
    if (!weekSelected) {
        const firstWeek = document.getElementById('curso0-1');
        if (firstWeek) {
            showValidationError(firstWeek, 'Seleccione al menos una semana');
            isValid = false;
            errors.push('Ninguna semana seleccionada');
        }
    }

    // Altersvalidierung für Geburtsdatum
    const birthdateField = document.getElementById('birthdate0');
    if (birthdateField && birthdateField.value) {
        const ageValidation = validateAge(birthdateField);
        if (!ageValidation.isValid) {
            isValid = false;
            errors.push('Edad: ' + ageValidation.message);
        }
    }

    // Anzeigen der Fehlermeldungen, falls vorhanden
    if (!isValid && errorField) {
        errorField.innerHTML = '<ul>' + errors.map(err => '<li>' + err + '</li>').join('') + '</ul>';
        errorField.style.display = 'block';
        
        // Scrolle zum ersten Fehler
        const firstErrorElement = document.querySelector('.validation-error');
        if (firstErrorElement) {
            firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        return false;
    }

    // Wenn alles gültig ist, sende das Formular ab
    if (isValid) {
        document.getElementById('formins').submit();
    }
    
    return isValid;
}
