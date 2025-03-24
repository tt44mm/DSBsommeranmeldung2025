/**
 * Reine JavaScript-Validierung für das Anmeldeformular
 * Ohne jQuery und andere externe Abhängigkeiten
 */

document.addEventListener('DOMContentLoaded', function() {
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
        if (!field || !message) return;
        
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
            // Für Radio-Buttons und Checkboxen verwenden wir den Namen
            selector = '.validationerror[data-for="' + field.name + '"]';
        } else if (field.id) {
            // Standard-Felder mit ID
            selector = '.validationerror[data-for="' + field.id + '"]';
        } else {
            // Felder ohne ID
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
        console.log("Starte Formularvalidierung");
        
        // Entferne zuerst alle vorhandenen Fehlermeldungen
        removeAllErrors();
        
        // Validiere alle Pflichtfelder
        let formValid = true;
        
        try {
            // Validiere einfache Eingabefelder
            const requiredInputs = document.querySelectorAll('#formins input.required, #formins select.required, #formins textarea.required');
            console.log("Gefundene Pflichtfelder (Inputs):", requiredInputs.length);
            
            // Limitiere die Anzahl der zu validierenden Felder (als Schutz)
            const fieldsToValidate = Math.min(requiredInputs.length, 50);
            
            for (let i = 0; i < fieldsToValidate; i++) {
                const field = requiredInputs[i];
                const isFieldValid = validateField(field, false);
                console.log("Validiere Feld:", field.id || field.name, "Ergebnis:", isFieldValid);
                
                if (!isFieldValid) {
                    formValid = false;
                }
            }
            
            // Validiere Radio-Gruppen
            const radioGroups = {};
            document.querySelectorAll('input[type="radio"].required').forEach(function(radio) {
                radioGroups[radio.name] = true;
            });
            
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
                    
                    if (!anyChecked) {
                        const isRadioValid = validateField(radios[0], false);
                        console.log("Validiere Radio-Gruppe", groupName, ":", isRadioValid);
                        if (!isRadioValid) {
                            formValid = false;
                        }
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
                
                if (!anyChecked) {
                    const isWeekValid = validateField(weekCheckboxes[0], false);
                    console.log("Validiere Wochen-Checkboxen:", isWeekValid);
                    if (!isWeekValid) {
                        formValid = false;
                    }
                }
            }
            
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
        } catch (e) {
            console.error("Fehler bei der Formularvalidierung:", e);
            formValid = false;
        }
        
        console.log("Gesamtergebnis der Formularvalidierung:", formValid);
        return formValid;
    }
    
    // Focus- und Blur-Events für alle Formularfelder
    const formFields = document.querySelectorAll('#formins input, #formins select, #formins textarea');
    formFields.forEach(function(field) {
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
                // Validiere das Feld
                validateField(field);
                
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
                
                // Wenn kein Fehler und Pflichtfeld, zeige grünen Haken
                if (!field.classList.contains('error') && field.classList.contains('required')) {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        // Für Checkboxen und Radio-Buttons verwenden wir data-attribute statt Klassen,
                        // unabhängig davon ob sie checked sind oder nicht
                        if (field.checked) {
                            field.setAttribute('data-validation-state', 'valid');
                        } else {
                            // Auch für unchecked Checkboxen setzen wir ein Attribut, um konsistente Größe zu gewährleisten
                            field.setAttribute('data-validation-state', 'unchecked');
                        }
                    } else if (field.type !== 'checkbox' && field.type !== 'radio' && 
                               field.value && typeof field.value === 'string' && field.value.trim() !== '') {
                        field.classList.add('valid');
                    }
                }
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
            width: 16px !important;
            height: 16px !important;
            min-width: 16px !important;
            min-height: 16px !important;
            max-width: 16px !important;
            max-height: 16px !important;
            box-sizing: border-box !important;
            appearance: auto !important;
        }
        
        /* Checkbox-spezifische Eigenschaften */
        input[type="checkbox"],
        input[type="checkbox"][data-validation-state="valid"],
        input[type="checkbox"][data-validation-state="error"],
        input[type="checkbox"][data-validation-state="unchecked"] {
            -webkit-appearance: checkbox !important;
            -moz-appearance: checkbox !important;
        }
        
        /* Radio-Button-spezifische Eigenschaften */
        input[type="radio"],
        input[type="radio"][data-validation-state="valid"],
        input[type="radio"][data-validation-state="error"],
        input[type="radio"][data-validation-state="unchecked"] {
            -webkit-appearance: radio !important;
            -moz-appearance: radio !important;
            border-radius: 50% !important;
        }
        
        /* Edge-spezifische Farbkorrekturen für Checkboxen und Radio-Buttons */
        @supports (-ms-ime-align:auto) {
            input[type="checkbox"]:checked, 
            input[type="radio"]:checked {
                accent-color: #0078d7 !important; /* Edge-Blau */
                color: #0078d7 !important;
            }
        }
        
        /* Standard-Farbe für moderne Browser */
        input[type="checkbox"]:checked, 
        input[type="radio"]:checked {
            accent-color: #0078d7 !important; /* Ähnlich Microsoft Blau */
        }
        
        /* Validierungsfehler-Container */
        .validationerror {
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            color: #dc3545 !important;
            margin-top: 0.25rem !important;
            font-size: 14px !important;
            font-weight: normal !important;
            padding: 0.5rem !important;
            background-color: rgba(220, 53, 69, 0.05) !important;
            border-radius: 0.25rem !important;
            border-left: 3px solid #dc3545 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
        }
    `;
    document.head.appendChild(style);
    
    // Debugging-Ausgabe
    console.log("Validierung initialisiert - optimierte Version");
}); 