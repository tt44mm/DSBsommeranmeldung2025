/**
 * Reine JavaScript-Validierung für das Anmeldeformular
 * Ohne jQuery und andere externe Abhängigkeiten
 * 
 * ZUSAMMENSPIEL MIT ANDEREN DATEIEN:
 * - Diese Datei: Komplexes Formular-Validierungssystem
 * - js-functions.js: UI-Funktionen und einfache Feld-Validierungen
 *
 * HINWEIS ZUR FUNKTIONSAUFTEILUNG:
 * Das validationRules-Objekt enthält Validierungsregeln, die teilweise
 * auch als eigenständige Funktionen in js-functions.js implementiert sind.
 * Bei Änderungen an der Validierungslogik müssen ggf. beide Dateien
 * angepasst werden.
 */

/**
 * Funktionsübersicht (25.03.2025):
 * 
 * required(value):
 *   Prüft, ob ein Pflichtfeld ausgefüllt ist.
 *   Wird für alle Pflichtfelder bei Eingabe, Verlassen des Feldes und Formularvalidierung aufgerufen.
 *
 * email(value):
 *   Validiert, ob eine E-Mail-Adresse ein gültiges Format hat.
 *   Wird bei E-Mail-Feldern bei Eingabe, Verlassen des Feldes und Formularvalidierung aufgerufen.
 *
 * equalTo(value, targetId):
 *   Prüft, ob zwei Felder denselben Wert haben (z.B. E-Mail-Wiederholung).
 *   Wird beim Vergleich der zwei E-Mail-Felder aufgerufen.
 *
 * minlength(value, length):
 *   Prüft, ob ein Wert eine Mindestlänge erreicht.
 *   Wird für Felder mit erforderlicher Mindestlänge aufgerufen.
 *
 * validateField(field, silent):
 *   Hauptfunktion zur Validierung eines einzelnen Feldes nach definierten Regeln.
 *   Wird für jedes Feld bei Eingabe, Verlassen und Formularabsendung aufgerufen.
 *
 * findParentByClassName(element, className):
 *   Hilfsfunktion zum Finden eines übergeordneten Elements anhand einer Klasse.
 *   Wird von Validierungsfunktionen verwendet, um Container-Elemente zu finden.
 *
 * findWeekSection():
 *   Findet den Bereich der Wochenauswahl-Checkboxen im Formular.
 *   Wird bei der Validierung der Wochenauswahl verwendet.
 *
 * showError(field, message):
 *   Zeigt eine Fehlermeldung für ein bestimmtes Feld an.
 *   Wird aufgerufen, wenn bei der Validierung eines Feldes ein Fehler festgestellt wird.
 *
 * handleRadioButtonError(field, errorContainer):
 *   Spezielle Fehlerbehandlung für Radio-Buttons.
 *   Wird aufgerufen, wenn ein Radio-Button-Fehler angezeigt werden soll.
 *
 * handleCheckboxError(field, errorContainer):
 *   Spezielle Fehlerbehandlung für Checkbox-Gruppen (Wochenauswahl).
 *   Wird aufgerufen, wenn die Wochenauswahl nicht valide ist.
 *
 * findLabelWithText(text):
 *   Findet Labels mit einem bestimmten Text.
 *   Wird für die präzise Fehlerplatzierung bei Radiobuttons und Checkboxen verwendet.
 *
 * handleTextareaError(field, errorContainer):
 *   Spezielle Fehlerbehandlung für Textarea-Felder.
 *   Wird aufgerufen, wenn ein Textarea-Feld nicht valide ist.
 *
 * handleStandardInputError(field, errorContainer):
 *   Standardbehandlung für Fehler bei einfachen Eingabefeldern.
 *   Wird für normale Textfelder, Zahlenfelder etc. bei Fehlern aufgerufen.
 *
 * removeError(field):
 *   Entfernt die Fehlermeldung für ein bestimmtes Feld.
 *   Wird aufgerufen, wenn ein Feld nach einer Korrektur wieder gültig ist.
 *
 * removeAllErrors():
 *   Entfernt alle Fehlermeldungen im gesamten Formular.
 *   Wird zu Beginn einer neuen Validierung aufgerufen, um vorherige Fehler zu löschen.
 *
 * validateForm():
 *   Zentrale Funktion zur Validierung des gesamten Formulars.
 *   Wird beim Absenden des Formulars aufgerufen und prüft alle Felder.
 *
 * submitclick():
 *   Vereinfachte Version der submitclick-Funktion auf globaler Ebene.
 *   Wird beim Klick auf den Submit-Button aufgerufen, um die Validierung zu starten.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Referenzen zu den Validierungsfunktionen aus js-functions.js
    const validatePLZFunc = window.validatePLZ || function() { return true; };
    const validatePhoneFunc = window.validatePhone || function() { return true; };
    const validateAgeFunc = window.validateAge || function() { return true; };
    
    // Definiere die Validierungsregeln für verschiedene Felder
    const validationRules = {
        // Allgemeine Regeln
        required: function(value) {
            // Spezielle Behandlung für undefined-Werte (z.B. bei Radio-Buttons/Checkboxen)
            if (value === undefined) {
                return false;
            }
            
            // Bei Strings den trim-Wert prüfen
            if (typeof value === 'string') {
                return value.trim() !== '';
            }
            
            // Für andere Datentypen
            return value !== null && value !== false;
        },
        email: function(value) {
            if (!value) return false;
            return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        },
        equalTo: function(value, targetId) {
            if (!value) return false;
            const targetValue = document.getElementById(targetId).value;
            return value === targetValue;
        },
        
        // Spezielle Regeln für das Formular
        minlength: function(value, length) {
            if (!value) return false;
            return value.length >= length;
        }
    };

    // Validierungsnachrichten
    const validationMessages = {
        required: 'Este campo es obligatorio.',
        email: 'Por favor, introduzca una dirección de correo electrónico válida.',
        equalTo: 'Los correos electrónicos deben coincidir.',
        minlength: 'Por favor, seleccione al menos un elemento.'
    };

    // Hauptvalidierungsfunktion
    function validateField(field, silent = false) {
        // Entferne bestehende Fehlermeldungen für dieses Feld
        removeError(field);
        
        let isValid = true;
        let errorMessage = '';
        
        // Spezialbehandlung für Radio-Buttons
        if (field.type === 'radio' && field.classList.contains('required')) {
            // Finde alle Radio-Buttons mit gleichem Namen
            const radioGroup = document.querySelectorAll('input[name="' + field.name + '"]');
            let anyChecked = false;
            
            radioGroup.forEach(function(radio) {
                if (radio.checked) {
                    anyChecked = true;
                }
            });
            
            if (!anyChecked) {
                isValid = false;
                errorMessage = validationMessages.required;
            }
        }
        // Spezialbehandlung für Checkboxen (einzeln oder als Gruppe)
        else if (field.type === 'checkbox' && field.classList.contains('required')) {
            // Wenn Teil einer Checkbox-Gruppe (mit [] im Namen)
            if (field.name.includes('[]')) {
                const checkboxGroup = document.querySelectorAll('input[name="' + field.name + '"]');
                let anyChecked = false;
                
                checkboxGroup.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        anyChecked = true;
                    }
                });
                
                if (!anyChecked) {
                    isValid = false;
                    errorMessage = validationMessages.required;
                }
            } 
            // Einzelne Checkbox
            else if (!field.checked) {
                isValid = false;
                errorMessage = validationMessages.required;
            }
        }
        // Standard-Validierung für andere Felder
        else if (field.classList.contains('required') && !validationRules.required(field.value)) {
            isValid = false;
            errorMessage = validationMessages.required;
        }
        
        // E-Mail-Validierung
        if (isValid && field.type === 'email' && field.value && !validationRules.email(field.value)) {
            isValid = false;
            errorMessage = validationMessages.email;
        }
        
        // Prüfe auf equalTo (für Email2)
        if (isValid && field.id === 'Email2' && field.value) {
            if (!validationRules.equalTo(field.value, 'Email1')) {
                isValid = false;
                errorMessage = 'El correo electrónico repetido tiene que ser identico con el correo electrónico en el campo anterior';
            }
        }
        
        // Checkbox-Gruppen für Wochen
        if (isValid && field.type === 'checkbox' && field.name === 'curso0[]' && field.checked === false) {
            // Wir müssen alle Checkboxen der Gruppe prüfen
            const checkboxGroup = document.querySelectorAll('input[name="curso0[]"]');
            let anyChecked = false;
            
            checkboxGroup.forEach(function(checkbox) {
                if (checkbox.checked) {
                    anyChecked = true;
                }
            });
            
            if (!anyChecked) {
                isValid = false;
                errorMessage = 'Es necesario seleccionar al menos una semana.';
            }
        }
        
        // Zeige Fehler oder Erfolg an
        if (!isValid && !silent) {
            showError(field, errorMessage);
        } else if (isValid) {
            if (field.type !== 'checkbox' && field.type !== 'radio') {
                field.classList.remove('error');
            } else {
                field.removeAttribute('data-validation-state');
            }
            
            // Nur für Pflichtfelder den grünen Haken zeigen
            if (field.classList.contains('required')) {
                // Checkbox und Radio-Button brauchen eine spezielle Behandlung
                if (field.type === 'checkbox' || field.type === 'radio') {
                    if (field.checked) {
                        field.setAttribute('data-validation-state', 'valid');
                    } else {
                        // Auch im 'unchecked'-Zustand ein data-Attribut setzen
                        field.setAttribute('data-validation-state', 'unchecked');
                    }
                } 
                // Andere Felder können einfach auf leeren Wert geprüft werden
                else if (typeof field.value === 'string' && field.value.trim() !== '') {
                    field.classList.add('valid');
                }
            }
        }
        
        return isValid;
    }
    
    // Hilfsfunktion, um ein übergeordnetes Element anhand einer Klasse zu finden
    function findParentByClassName(element, className) {
        if (!element) return null;
        
        let parent = element.parentNode;
        let count = 0; // Schutz vor Endlosschleifen
        
        while (parent && count < 20) { // Begrenze die Anzahl der Iterationen
            if (parent.classList && parent.classList.contains(className)) {
                return parent;
            }
            parent = parent.parentNode;
            count++;
        }
        return null;
    }
    
    // Speziell für Wochenauswahl - Fallback ohne :has Selektor
    function findWeekSection() {
        // Direkter Versuch, das Element zu finden
        const sections = document.querySelectorAll('.form-row');
        for (let i = 0; i < sections.length; i++) {
            if (sections[i].querySelector('input[name="curso0[]"]')) {
                return sections[i];
            }
        }
        return null;
    }
    
    // Fehlermeldung anzeigen - optimierte Version
    function showError(field, message) {
        if (!field || !message) {
            console.log("showError: Feld oder Nachricht fehlt", field, message);
            return;
        }
        
        console.log("showError wird aufgerufen für:", field.id || field.name, "mit Nachricht:", message);
        
        // Zuerst vorhandene Fehlermeldungen für dieses Feld entfernen
        removeError(field);
        
        // Erstelle Container für die Fehlermeldung
        const errorContainer = document.createElement('div');
        errorContainer.className = 'validationerror';
        errorContainer.style.display = 'block';
        errorContainer.style.visibility = 'visible';
        errorContainer.style.opacity = '1';
        
        // Erstelle die Fehlermeldung
        const errorMessage = document.createElement('span');
        errorMessage.textContent = message;
        
        // Füge die Fehlermeldung zum Container hinzu
        errorContainer.appendChild(errorMessage);
        
        try {
            // Set data-for attribute for the error container
            if (field.type === 'radio' || field.type === 'checkbox') {
                errorContainer.setAttribute('data-for', field.name);
            } else if (field.id) {
                errorContainer.setAttribute('data-for', field.id);
            } else {
                errorContainer.setAttribute('data-for', field.name);
            }
            
            // Spezielle Behandlung basierend auf dem Feldtyp
            if (field.type === 'radio') {
                // 1. Radiobuttons: Fehlertext in eigener Zeile unter dem ersten Radiobutton
                handleRadioButtonError(field, errorContainer);
            } else if (field.type === 'checkbox' && field.name === 'curso0[]') {
                // 2. Checkbox-Fehlermeldung: Anzeige nur unter dem Label
                handleCheckboxError(field, errorContainer);
            } else if (field.tagName && field.tagName.toLowerCase() === 'textarea') {
                // 3. & 4. Textareas (Observaciones & Indiquenos): Fehler unter dem Input
                handleTextareaError(field, errorContainer);
            } else {
                // Standard-Behandlung für andere Eingabefelder
                handleStandardInputError(field, errorContainer);
            }
            
            // Markiere das Feld als ungültig, aber nicht für Checkboxen und Radio-Buttons
            if (field.type !== 'checkbox' && field.type !== 'radio') {
                field.classList.add('error');
                field.classList.remove('valid');
            } else {
                // Für Checkboxen und Radio-Buttons fügen wir nur ein data-Attribut hinzu
                // anstatt die Klasse zu ändern, um visuelle Probleme zu vermeiden
                field.setAttribute('data-validation-state', 'error');
            }
            
        } catch (e) {
            console.error("Fehler beim Anzeigen der Fehlermeldung:", e);
        }
    }
    
    // Hilfsfunktion für Radiobutton-Fehler
    function handleRadioButtonError(field, errorContainer) {
        // Finde die Formularzeile, die die Radio-Button-Gruppe enthält
        const formRow = findParentByClassName(field, 'form-row');
        
        if (formRow) {
            // Finde das übergeordnete div.col-auto, das die Radio-Buttons enthält
            const colAuto = formRow.querySelector('.col-auto:not(.labelYesNo)');
            
            if (colAuto) {
                // Lösche zuerst alle vorhandenen leeren DIVs und Fehlermeldungen
                const existingDivs = colAuto.querySelectorAll('div[style*="width: 100%; clear: both"]');
                existingDivs.forEach(div => {
                    div.parentNode.removeChild(div);
                });
                
                // Füge die Fehlermeldung direkt ein ohne ein zusätzliches Wrapper-Div
                colAuto.appendChild(errorContainer);
                
                // Stil der Fehlermeldung direkt anpassen
                errorContainer.style.width = '100%';
                errorContainer.style.clear = 'both';
                errorContainer.style.marginTop = '10px';
                errorContainer.style.marginBottom = '5px';
            } else {
                // Fallback: Normales Einfügen am Ende der formRow
                formRow.appendChild(errorContainer);
            }
        } else {
            // Fallback: Füge nach dem Radio-Button ein
            field.parentNode.appendChild(errorContainer);
        }
    }
    
    // Hilfsfunktion für Checkbox-Fehler in der Wochenauswahl
    function handleCheckboxError(field, errorContainer) {
        // Direkte Suche nach dem div#cursos Element
        const cursosDiv = document.getElementById('cursos');
        
        if (cursosDiv) {
            // Platziere die Fehlermeldung direkt vor dem cursos-Bereich
            cursosDiv.parentNode.insertBefore(errorContainer, cursosDiv);
            
            // Stil anpassen
            errorContainer.style.width = '100%';
            errorContainer.style.display = 'block';
            errorContainer.style.clear = 'both';
            errorContainer.style.marginTop = '0';
            errorContainer.style.marginBottom = '10px';
            errorContainer.style.fontWeight = 'bold';
            return;
        }
        
        // Alternatives Vorgehen: Direkte Suche nach tabellarischem Layout
        const weekTable = document.querySelector('#cursos table.table');
        if (weekTable) {
            // Platziere die Fehlermeldung vor der Tabelle
            weekTable.parentNode.insertBefore(errorContainer, weekTable);
            
            // Stil anpassen
            errorContainer.style.width = '100%';
            errorContainer.style.display = 'block';
            errorContainer.style.marginTop = '0';
            errorContainer.style.marginBottom = '10px';
            return;
        }
        
        // Fallback: Suche nach dem parent div der Checkboxen
        const checkboxParent = field.closest('.form-row') || field.closest('div');
        if (checkboxParent) {
            const firstChild = checkboxParent.querySelector('label, div, table');
            if (firstChild) {
                // Füge es nach dem ersten Element ein
                if (firstChild.nextSibling) {
                    checkboxParent.insertBefore(errorContainer, firstChild.nextSibling);
                } else {
                    checkboxParent.appendChild(errorContainer);
                }
            } else {
                // Füge es am Anfang ein
                if (checkboxParent.firstChild) {
                    checkboxParent.insertBefore(errorContainer, checkboxParent.firstChild);
                } else {
                    checkboxParent.appendChild(errorContainer);
                }
            }
        } else {
            // Letzter Fallback: Direkt nach dem Feld einfügen
            field.parentNode.insertBefore(errorContainer, field.nextSibling);
        }
    }
    
    // Verbesserte Funktion zum Finden von Labels mit bestimmtem Text
    function findLabelWithText(text) {
        const labels = document.querySelectorAll('label');
        for (let i = 0; i < labels.length; i++) {
            if (labels[i].textContent && labels[i].textContent.indexOf(text) !== -1) {
                return labels[i];
            }
        }
        return null;
    }
    
    // Hilfsfunktion für Textarea-Fehler
    function handleTextareaError(field, errorContainer) {
        // Für Textarea Observaciones
        if (field.id === 'observaciones') {
            console.log("Platziere Fehlermeldung für Observaciones");
            
            // Finde das übergeordnete Element, das das Label und Textarea enthält
            const formGroup = field.closest('.form-group');
            
            if (formGroup) {
                // Platziere nach dem Textarea
                formGroup.appendChild(errorContainer);
                
                // Stil anpassen
                errorContainer.style.width = '100%';
                errorContainer.style.display = 'block';
                errorContainer.style.marginTop = '5px';
                errorContainer.style.marginLeft = '0';
                
                console.log("Fehlermeldung für Observaciones platziert");
                return;
            }
        }
        
        // Für Textarea Indiquenos
        if (field.id === 'infoKursFundort') {
            console.log("Platziere Fehlermeldung für Indiquenos");
            
            // Finde das übergeordnete Element, das das Label und Textarea enthält
            const formGroup = field.closest('.form-group');
            
            if (formGroup) {
                // Platziere nach dem Textarea
                formGroup.appendChild(errorContainer);
                
                // Stil anpassen
                errorContainer.style.width = '100%';
                errorContainer.style.display = 'block';
                errorContainer.style.marginTop = '5px';
                errorContainer.style.marginLeft = '0';
                
                console.log("Fehlermeldung für Indiquenos platziert");
                return;
            }
        }
        
        // Generischer Fall
        console.log("Generischer Fall für Textarea-Fehler");
        
        // Finde das übergeordnete Element, das das Label und Textarea enthält
        const formGroup = field.closest('.form-group') || field.closest('div');
        
        if (formGroup) {
            // Platziere nach dem Textarea
            formGroup.appendChild(errorContainer);
            
            // Stil anpassen
            errorContainer.style.width = '100%';
            errorContainer.style.display = 'block';
            errorContainer.style.marginTop = '5px';
            errorContainer.style.marginLeft = '0';
            
            console.log("Fehlermeldung für Textarea platziert");
        } else {
            // Fallback: Nach dem Feld einfügen
            if (field.nextSibling) {
                field.parentNode.insertBefore(errorContainer, field.nextSibling);
            } else {
                field.parentNode.appendChild(errorContainer);
            }
            console.log("Fallback für Textarea-Fehler verwendet");
        }
    }
    
    // Hilfsfunktion für Standard-Eingabefelder
    function handleStandardInputError(field, errorContainer) {
        // Finde den übergeordneten Container des Eingabefeldes
        const parent = field.parentNode;
        
        if (parent) {
            // Füge die Fehlermeldung direkt nach dem Eingabefeld ein
            if (field.nextSibling) {
                parent.insertBefore(errorContainer, field.nextSibling);
            } else {
                parent.appendChild(errorContainer);
            }
        } else {
            // Fallback: Füge nach dem Feld ein
            field.parentNode.appendChild(errorContainer);
        }
    }
    
    // Fehlermeldung entfernen
    function removeError(field) {
        let selector;
        
        // Spezialbehandlung für Radio-Buttons und Checkboxen
        if (field.type === 'radio' || field.type === 'checkbox') {
            selector = '.validationerror[data-for="' + field.name + '"]';
        } else if (field.id) {
            selector = '.validationerror[data-for="' + field.id + '"]';
        } else {
            selector = '.validationerror[data-for="' + field.name + '"]';
        }
        
        // Alle Fehlermeldungen für dieses Feld entfernen
        const errorMessages = document.querySelectorAll(selector);
        errorMessages.forEach(function(container) {
            if (container && container.parentElement) {
                container.parentElement.removeChild(container);
            }
        });
        
        // Entferne Fehlerklassen oder -attribute je nach Feldtyp
        if (field.type === 'checkbox' || field.type === 'radio') {
            field.removeAttribute('data-validation-state');
        } else {
            field.classList.remove('error');
        }
    }
    
    // Entferne alle Fehlermeldungen
    function removeAllErrors() {
        // Entferne neue validationerror-Elemente
        const allErrors = document.querySelectorAll('.validationerror');
        allErrors.forEach(function(error) {
            if (error.parentElement) {
                error.parentElement.removeChild(error);
            }
        });
        
        // Entferne alle Fehlerklassen
        const formElements = document.querySelectorAll('input, select, textarea');
        formElements.forEach(function(element) {
            element.classList.remove('error');
            element.classList.remove('valid');
            
            // Entferne auch die data-validation-state-Attribute
            if (element.type === 'checkbox' || element.type === 'radio') {
                element.removeAttribute('data-validation-state');
            }
        });
    }

    // Funktion zur Validierung des gesamten Formulars
    function validateForm() {
        console.log("===== VALIDIERUNG GESTARTET =====");
        
        // Entferne zuerst alle vorhandenen Fehlermeldungen
        removeAllErrors();
        
        // Validiere alle Pflichtfelder
        let formValid = true;
        let requiredValid = true;
        let formatValid = true;
        
        try {
            // SCHRITT 1: REQUIRED CHECK - Prüfe ob Pflichtfelder ausgefüllt sind
            console.log("===== REQUIRED CHECK GESTARTET =====");
            
            // Sammle alle Radio-Gruppen
            const radioGroups = {};
            document.querySelectorAll('input[type="radio"].required').forEach(function(radio) {
                radioGroups[radio.name] = true;
            });
            
            // Sammle alle Wochen-Checkboxen
            const weekCheckboxIds = [];
            document.querySelectorAll('input[name="curso0[]"]').forEach(function(checkbox) {
                if (checkbox.id) {
                    weekCheckboxIds.push(checkbox.id);
                }
            });
            
            // Validiere einfache Eingabefelder (ohne Radio-Buttons und ohne Wochen-Checkboxen)
            const requiredInputs = document.querySelectorAll('#formins input.required:not([type="radio"]), #formins select.required, #formins textarea.required');
            const filteredInputs = [];
            
            // Filtere Wochen-Checkboxen aus den einzeln zu validierenden Feldern heraus
            for (let i = 0; i < requiredInputs.length; i++) {
                const field = requiredInputs[i];
                if (field.type === 'checkbox' && weekCheckboxIds.includes(field.id)) {
                    continue; // überspringe Wochen-Checkboxen
                }
                filteredInputs.push(field);
            }
            
            console.log("Gefundene Pflichtfelder (Inputs):", filteredInputs.length);
            
            // Limitiere die Anzahl der zu validierenden Felder (als Schutz)
            const fieldsToValidate = Math.min(filteredInputs.length, 50);
            
            for (let i = 0; i < fieldsToValidate; i++) {
                const field = filteredInputs[i];
                
                // Prüfe zunächst nur auf Vorhandensein (required)
                let isEmpty = false;
                
                if (field.type === 'checkbox') {
                    isEmpty = !field.checked;
                } else {
                    isEmpty = !field.value.trim();
                }
                
                const fieldRequiredValid = !isEmpty;
                console.log(`Validierung REQUIRED für ${field.id || field.name}: ${fieldRequiredValid ? 'TRUE' : 'FALSE'}`);
                
                if (!fieldRequiredValid) {
                    requiredValid = false;
                    formValid = false;
                }
                
                // Führe die vollständige Validierung durch (inkl. Format)
                validateField(field, false);
            }
            
            // Validiere Radio-Gruppen
            Object.keys(radioGroups).forEach(function(groupName) {
                const radios = document.querySelectorAll('input[name="' + groupName + '"]');
                if (radios.length > 0) {
                    let anyChecked = false;
                    
                    for (let i = 0; i < radios.length; i++) {
                        if (radios[i].checked) {
                            anyChecked = true;
                            break;
                        }
                    }
                    
                    // Log einzelne Radio-Button-Status für Debugging
                    radios.forEach(function(radio) {
                        console.log(`Validierung REQUIRED für ${radio.id || radio.name}: ${radio.checked ? 'TRUE' : 'FALSE'}`);
                    });
                    
                    const radioRequired = anyChecked;
                    console.log(`Validierung REQUIRED für Radio-Gruppe ${groupName}: ${radioRequired ? 'TRUE' : 'FALSE'}`);
                    
                    if (!radioRequired) {
                        requiredValid = false;
                        formValid = false;
                        validateField(radios[0], false);
                    }
                }
            });
            
            // Validiere Wochen-Checkboxen
            const weekCheckboxes = document.querySelectorAll('input[name="curso0[]"]');
            if (weekCheckboxes && weekCheckboxes.length > 0) {
                let anyChecked = false;
                
                for (let i = 0; i < weekCheckboxes.length; i++) {
                    if (weekCheckboxes[i].checked) {
                        anyChecked = true;
                        break;
                    }
                }
                
                // Log einzelne Checkbox-Status für Debugging
                weekCheckboxes.forEach(function(checkbox) {
                    console.log(`Validierung REQUIRED für ${checkbox.id || checkbox.name}: ${checkbox.checked ? 'TRUE' : 'FALSE'}`);
                });
                
                const checkboxesRequired = anyChecked;
                console.log(`Validierung REQUIRED für Wochen-Checkboxen: ${checkboxesRequired ? 'TRUE' : 'FALSE'}`);
                
                if (!checkboxesRequired) {
                    requiredValid = false;
                    formValid = false;
                    validateField(weekCheckboxes[0], false);
                }
            }
            
            // Aktualisiere requiredValid basierend auf allen Validierungen
            console.log(`===== REQUIRED CHECK ERGEBNIS: ${requiredValid ? 'TRUE' : 'FALSE'} =====`);
            
            // SCHRITT 2: FORMAT CHECK - Prüfe spezielle Formate
            console.log("===== FORMAT CHECK GESTARTET =====");
            
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
            
            // Telefon validieren
            const phoneField = document.getElementById('Phone');
            if (phoneField && phoneField.value.trim()) { // Nur validieren, wenn nicht leer
                const phoneRegex = /^[+]?[0-9 ]+$/;
                const phoneValue = phoneField.value.trim();
                const phoneFormatValid = phoneRegex.test(phoneValue);
                
                console.log(`Validierung FORMAT für Phone: ${phoneFormatValid ? 'TRUE' : 'FALSE'} (Wert: ${phoneValue})`);
                
                if (!phoneFormatValid) {
                    formatValid = false;
                    formValid = false;
                    // Fehlermeldung direkt anzeigen und Bestätigung loggen
                    console.log('Zeige Fehlermeldung für Phone');
                    showError(phoneField, 'El número de teléfono debe contener solo dígitos, espacios y opcionalmente un signo "+" al inicio.');
                }
            }
            
            // Zusätzliches Telefon validieren
            const phone0Field = document.getElementById('phone0');
            if (phone0Field && phone0Field.value.trim()) {
                const phoneRegex = /^[+]?[0-9 ]+$/;
                const phoneValue = phone0Field.value.trim();
                const phone0FormatValid = phoneRegex.test(phoneValue);
                
                console.log(`Validierung FORMAT für phone0: ${phone0FormatValid ? 'TRUE' : 'FALSE'} (Wert: ${phoneValue})`);
                
                if (!phone0FormatValid) {
                    formatValid = false;
                    formValid = false;
                    // Fehlermeldung direkt anzeigen und Bestätigung loggen
                    console.log('Zeige Fehlermeldung für phone0');
                    showError(phone0Field, 'El número de teléfono adicional debe contener solo dígitos, espacios y opcionalmente un signo "+" al inicio.');
                }
            }
            
            console.log(`===== FORMAT CHECK ERGEBNIS: ${formatValid ? 'TRUE' : 'FALSE'} =====`);
            
            // SCHRITT 3: SPEZIAL CHECK - Prüfe spezielle Validierungen wie Alter
            console.log("===== SPEZIAL CHECK GESTARTET =====");
            let specialValid = true;
            
            // Validiere das Geburtsdatum und Alter
            const birthdateField = document.getElementById('birthdate0');
            if (birthdateField && birthdateField.value.trim()) {
                // Verwende die existierende validateAgeFunc-Funktion aus js-functions.js
                if (typeof validateAgeFunc === 'function') {
                    const ageResult = validateAgeFunc(birthdateField);
                    console.log(`Validierung SPEZIAL für birthdate0 (Alter): ${ageResult ? 'TRUE' : 'FALSE'}`);
                    
                    if (!ageResult) {
                        specialValid = false;
                        formValid = false;
                        // Fehlermeldung wird durch validateAge gesetzt
                    }
                } else {
                    console.error('validateAgeFunc Funktion nicht gefunden - Altersvalidierung übersprungen');
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
                    formValid = false;
                    showError(email2Field, 'El correo electrónico repetido tiene que ser idéntico con el correo electrónico en el campo anterior');
                }
            }
            
            console.log(`===== SPEZIAL CHECK ERGEBNIS: ${specialValid ? 'TRUE' : 'FALSE'} =====`);
            
            // Nach der Validierung alle erzeugten Fehler explizit sichtbar machen
            document.querySelectorAll('.validationerror').forEach(function(error) {
                error.style.display = 'block';
                error.style.visibility = 'visible';
            });
            
            // Scrolle zum ersten Fehler, wenn vorhanden
            if (!formValid) {
                const firstError = document.querySelector('.validationerror');
                if (firstError) {
                    console.log("Erster Fehler gefunden, scrolle zur Position");
                    setTimeout(function() {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                }
            }
            
            // Ausgabe der Gesamtergebnisse
            console.log("===== VALIDIERUNGSGESAMTERGEBNIS =====");
            
            // Neuen Check hinzufügen: Wenn alle Gruppen valide sind und nur einzelne Wochen-Checkboxen invalide sind,
            // dann setze requiredValid auf true
            const allRadioGroupsValid = Object.keys(radioGroups).every(function(groupName) {
                const radios = document.querySelectorAll('input[name="' + groupName + '"]');
                if (radios.length > 0) {
                    for (let i = 0; i < radios.length; i++) {
                        if (radios[i].checked) {
                            return true;
                        }
                    }
                    return false;
                }
                return true; // Wenn keine Radio-Buttons vorhanden sind, gilt die Gruppe als gültig
            });
            
            const weekCheckboxesValid = (function() {
                const checkboxes = document.querySelectorAll('input[name="curso0[]"]');
                if (checkboxes && checkboxes.length > 0) {
                    for (let i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked) {
                            return true;
                        }
                    }
                    return false;
                }
                return true; // Wenn keine Checkboxen vorhanden sind, gilt die Gruppe als gültig
            })();
            
            // Wenn alle Gruppen gültig sind, dann setze das Gesamtergebnis auf true
            if (allRadioGroupsValid && weekCheckboxesValid) {
                // Altes Verhalten (fehlerhaft):
                // requiredValid = true;
                // formValid = formatValid && specialValid;
                
                // Korrigiertes Verhalten:
                // Setze requiredValid nur auf true, wenn keine Fehler in Pflichtfeldern vorhanden sind
                // Wir prüfen dazu, ob Fehlermeldungen für Pflichtfelder existieren
                const requiredErrors = document.querySelectorAll('.validationerror');
                const hasRequiredErrors = requiredErrors.length > 0;
                
                if (!hasRequiredErrors) {
                    requiredValid = true;
                    formValid = formatValid && specialValid;
                } else {
                    // Beibehalten des false-Status, wenn Pflichtfelder nicht ausgefüllt sind
                    formValid = false;
                }
            }
            
            console.log(`REQUIRED (korrigiert): ${requiredValid ? 'TRUE' : 'FALSE'} | FORMAT: ${formatValid ? 'TRUE' : 'FALSE'} | SPECIAL: ${specialValid ? 'TRUE' : 'FALSE'}`);
            console.log(`Gesamtergebnis der Formularvalidierung: ${formValid ? 'TRUE' : 'FALSE'}`);
        } catch (e) {
            console.error("Fehler bei der Formularvalidierung:", e);
            formValid = false;
        }
        
        return formValid;
    }
    
    // Focus- und Blur-Events für alle Formularfelder
    const formFields = document.querySelectorAll('#formins input, #formins select, #formins textarea');
    formFields.forEach(function(field) {
        // Füge input-Event-Listener für spezielle Felder hinzu
        if ((field.id === 'PLZ' || field.id === 'Phone' || field.id === 'phone0') && field.type === 'text') {
            field.addEventListener('input', function() {
                try {
                    // Rufe die entsprechende Validierungsfunktion auf
                    if (field.id === 'PLZ' && typeof validatePLZFunc === 'function') {
                        // Prüfe zuerst, ob das Feld ausgefüllt ist, wenn es ein Pflichtfeld ist
                        if (field.classList.contains('required') && field.value.trim() === '') {
                            showError(field, 'Dieses Feld ist erforderlich.');
                        } else {
                            // Vor der Validierung den error-Status entfernen
                            field.classList.remove('error');
                            const result = validatePLZFunc(field);
                            // Wenn die Validierung erfolgreich ist und das Feld nicht leer ist, setze valid-Klasse
                            if (result && field.value.trim() !== '') {
                                field.classList.add('valid');
                            }
                        }
                    } else if ((field.id === 'Phone' || field.id === 'phone0') && typeof validatePhoneFunc === 'function') {
                        // Prüfe zuerst, ob das Feld ausgefüllt ist, wenn es ein Pflichtfeld ist
                        if (field.classList.contains('required') && field.value.trim() === '') {
                            showError(field, 'Dieses Feld ist erforderlich.');
                        } else {
                            // Vor der Validierung den error-Status entfernen
                            field.classList.remove('error');
                            const result = validatePhoneFunc(field);
                            // Wenn die Validierung erfolgreich ist und das Feld nicht leer ist, setze valid-Klasse
                            if (result && field.value.trim() !== '') {
                                field.classList.add('valid');
                            }
                        }
                    }
                } catch (e) {
                    console.error("Fehler im Input-Event:", e);
                }
            });
        }
        
        // Bei Focus: Fehlermeldung ausblenden
        field.addEventListener('focus', function() {
            try {
                // Verstecke Fehlermeldungen
                let selector;
                
                // Unterscheide zwischen verschiedenen Feldtypen
                if (field.type === 'radio' || field.type === 'checkbox') {
                    selector = '.validationerror[data-for="' + field.name + '"]';
                } else if (field.id) {
                    selector = '.validationerror[data-for="' + field.id + '"]';
                } else {
                    selector = '.validationerror[data-for="' + field.name + '"]';
                }
                
                const errors = document.querySelectorAll(selector);
                errors.forEach(function(error) {
                    error.style.display = 'none';
                });
            } catch (e) {
                console.error("Fehler im Focus-Event:", e);
            }
        });
        
        // Bei Blur: Wenn Pflichtfeld, validieren und ggf. Fehlermeldung oder grünen Haken anzeigen
        field.addEventListener('blur', function() {
            try {
                // Spezielle Validierungsfunktionen für bestimmte Felder aufrufen
                if (field.id === 'PLZ' && typeof validatePLZFunc === 'function') {
                    // Prüfe zuerst, ob das Feld ausgefüllt ist, wenn es ein Pflichtfeld ist
                    if (field.classList.contains('required') && field.value.trim() === '') {
                        showError(field, 'Dieses Feld ist erforderlich.');
                    } else {
                        // Vor der Validierung den error-Status entfernen
                        field.classList.remove('error');
                        const result = validatePLZFunc(field);
                        // Wenn die Validierung erfolgreich ist und das Feld nicht leer ist, setze valid-Klasse
                        if (result && field.value.trim() !== '') {
                            field.classList.add('valid');
                        }
                    }
                } else if ((field.id === 'Phone' || field.id === 'phone0') && typeof validatePhoneFunc === 'function') {
                    // Prüfe zuerst, ob das Feld ausgefüllt ist, wenn es ein Pflichtfeld ist
                    if (field.classList.contains('required') && field.value.trim() === '') {
                        showError(field, 'Dieses Feld ist erforderlich.');
                    } else {
                        // Vor der Validierung den error-Status entfernen
                        field.classList.remove('error');
                        const result = validatePhoneFunc(field);
                        // Wenn die Validierung erfolgreich ist und das Feld nicht leer ist, setze valid-Klasse
                        if (result && field.value.trim() !== '') {
                            field.classList.add('valid');
                        }
                    }
                } else if (field.id === 'birthdate0' && typeof validateAgeFunc === 'function') {
                    // Prüfe zuerst, ob das Feld ausgefüllt ist, wenn es ein Pflichtfeld ist
                    if (field.classList.contains('required') && field.value.trim() === '') {
                        showError(field, 'Dieses Feld ist erforderlich.');
                    } else {
                        // Vor der Validierung den error-Status entfernen
                        field.classList.remove('error');
                        const result = validateAgeFunc(field);
                        // Wenn die Validierung erfolgreich ist und das Feld nicht leer ist, setze valid-Klasse
                        if (result && field.value.trim() !== '') {
                            field.classList.add('valid');
                        }
                    }
                } else {
                    // Standardvalidierung für alle anderen Felder
                    const result = validateField(field);
                    // Wenn die Validierung erfolgreich ist und das Feld nicht leer ist, setze valid-Klasse
                    if (result && field.value.trim() !== '') {
                        field.classList.add('valid');
                    }
                }
                
                // Zeige Fehlermeldungen wieder an, wenn vorhanden
                let selector;
                
                // Unterscheide zwischen verschiedenen Feldtypen
                if (field.type === 'radio' || field.type === 'checkbox') {
                    selector = '.validationerror[data-for="' + field.name + '"]';
                } else if (field.id) {
                    selector = '.validationerror[data-for="' + field.id + '"]';
                } else {
                    selector = '.validationerror[data-for="' + field.name + '"]';
                }
                
                const errors = document.querySelectorAll(selector);
                errors.forEach(function(error) {
                    error.style.display = 'block';
                });
            } catch (e) {
                console.error("Fehler im Blur-Event:", e);
            }
        });
    });
    
    // Checkbox-Gruppen-Validierung für die Wochen
    const checkboxes = document.querySelectorAll('input[name="curso0[]"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            try {
                // Finde ein beliebiges Checkbox-Element in der Gruppe
                const anyCheckbox = document.querySelector('input[name="curso0[]"]');
                if (anyCheckbox) {
                    validateField(anyCheckbox);
                }
            } catch (e) {
                console.error("Fehler im Checkbox-Change-Event:", e);
            }
        });
    });
    
    // Verbesserte Formularvalidierung beim Absenden
    document.addEventListener('submit', function(event) {
        if (event.target.id === 'formins') {
            console.log("Formular wird abgesendet, Validierung beginnt");
            // Verhindere das Standard-Submit-Verhalten zunächst
            event.preventDefault();
            
            // Führe die Validierung durch
            const isValid = validateForm();
            console.log("Formularvalidierung Ergebnis:", isValid);
            
            if (isValid) {
                // Wenn alles gültig ist, führe das Formular manuell aus
                console.log("Formular ist gültig, wird jetzt abgesendet");
                try {
                    event.target.submit();
                } catch (e) {
                    console.error("Fehler beim Submit:", e);
                    // Versuche es erneut über die DOM-Methode
                    document.getElementById('formins').submit();
                }
            } else {
                console.log("Formular ist ungültig, Absenden wurde verhindert");
            }
        }
    }, true);

    // Überschreibe die submitclick-Funktion auf globaler Ebene - vereinfacht
    window.submitclick = function() {
        console.log("submitclick wurde aufgerufen");
        try {
            const isValid = validateForm();
            console.log("submitclick Validierungsergebnis:", isValid);
            
            if (isValid) {
                return true;
            } else {
                // Zeige Fehler an und scrolle zum ersten Fehler
                const firstError = document.querySelector('.validationerror');
                if (firstError) {
                    setTimeout(function() {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, 100);
                }
                return false;
            }
        } catch (e) {
            console.error("Fehler in submitclick:", e);
            return false;
        }
    };
    
    // CSS für Validierungsstile dynamisch einfügen
    const style = document.createElement('style');
    style.textContent = `
        /* Generelle Stile für normale Formularelemente */
        input:not([type="checkbox"]):not([type="radio"]).error,
        select.error,
        textarea.error {
            border-color: #dc3545 !important;
        }
        
        input:not([type="checkbox"]):not([type="radio"]).valid,
        select.valid,
        textarea.valid {
            border-color: #28a745 !important;
        }
        
        /* Keine visuellen Änderungen bei Checkboxen und Radio-Buttons */
        input[type="checkbox"],
        input[type="radio"],
        input[type="checkbox"][data-validation-state="valid"],
        input[type="radio"][data-validation-state="valid"],
        input[type="checkbox"][data-validation-state="error"],
        input[type="radio"][data-validation-state="error"],
        input[type="checkbox"][data-validation-state="unchecked"],
        input[type="radio"][data-validation-state="unchecked"] {
            /* Keine speziellen Stile notwendig */
        }
        
        /* Fehlermeldungen */
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
        
        /* Suchefeld mit speziellem Platzhalter */
        .custom-select {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
        
        /* Wochenauswahl - Containerklassen */
        .form-group.weeks-container {
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            background-color: #f8f9fa;
        }
        
        /* Checkboxen in der Wochenauswahl */
        .form-group.weeks-container input[type="checkbox"][data-validation-state="error"] + label {
            color: #dc3545;
            font-weight: bold;
        }
        
        /* Ausrichtung für Radio-Button-Gruppierungen */
        .form-check-inline {
            display: inline-flex;
            align-items: center;
            padding-left: 0;
            margin-right: 0.75rem;
        }
    `;
    document.head.appendChild(style);
    
    // Debugging-Ausgabe
    console.log("Validierung initialisiert - optimierte Version");
}); 