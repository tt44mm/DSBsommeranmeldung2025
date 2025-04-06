<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

// Initialisierung der Werte (leer, wenn das Formular zum ersten Mal angezeigt wird)
$POSTARRAY = array(
    'pflichtfelttext' => '',
    'nopflichtfelttext' => '',
    'telefon' => '',
    'plz' => '',
    'Geburtstag' => '',
    'email1' => '',
    'email2' => '',
    'radios' => '',
    'checks' => array(),
    'Langtexte' => '',
    'selectdropdown' => ''
);

// Wenn Formular gesendet wurde, Werte übernehmen
if (sizeof($_POST) > 0) {
    // Sicheres Übernehmen der POST-Daten
    $POSTARRAY['pflichtfelttext'] = isset($_POST['pflichtfelttext']) ? htmlspecialchars($_POST['pflichtfelttext']) : '';
    $POSTARRAY['nopflichtfelttext'] = isset($_POST['nopflichtfelttext']) ? htmlspecialchars($_POST['nopflichtfelttext']) : '';
    $POSTARRAY['telefon'] = isset($_POST['telefon']) ? htmlspecialchars($_POST['telefon']) : '';
    $POSTARRAY['plz'] = isset($_POST['plz']) ? htmlspecialchars($_POST['plz']) : '';
    $POSTARRAY['Geburtstag'] = isset($_POST['Geburtstag']) ? htmlspecialchars($_POST['Geburtstag']) : '';
    $POSTARRAY['email1'] = isset($_POST['email1']) ? htmlspecialchars($_POST['email1']) : '';
    $POSTARRAY['email2'] = isset($_POST['email2']) ? htmlspecialchars($_POST['email2']) : '';
    $POSTARRAY['radios'] = isset($_POST['radios']) ? htmlspecialchars($_POST['radios']) : '';
    $POSTARRAY['checks'] = isset($_POST['checks']) ? $_POST['checks'] : array();
    $POSTARRAY['Langtexte'] = isset($_POST['Langtexte']) ? htmlspecialchars($_POST['Langtexte']) : '';
    $POSTARRAY['selectdropdown'] = isset($_POST['selectdropdown']) ? htmlspecialchars($_POST['selectdropdown']) : '';
}

// Zeige Ergebnis nach erfolgreichem Submit
$showResults = sizeof($_POST) > 0;

// Helper-Funktion zum Prüfen, ob eine Checkbox ausgewählt wurde
function isChecked($value, $array) {
    return in_array($value, $array) ? 'checked="checked"' : '';
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Form Validations</title>
    
    <!-- Bootstrap CSS für ein ansprechendes Layout -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Validierungsstile -->
    <link rel="stylesheet" href="css/validation-styles_2.css">
    
    <!-- Formular-Stile -->
    <link rel="stylesheet" href="css/dsbform_2.css">
    
    <!-- Reine JavaScript-Validierung -->
    <script src="js/pure-validation.js"></script>
    
    <!-- Zusätzliche JavaScript-Funktionen -->
    <script src="js/js-functions.js"></script>
</head>
<body>

<div class="container mt-4">
    <h1 class="mb-4">Test Form Validations</h1>
    
    <?php if ($showResults): ?>
    <!-- Ergebnisanzeige nach Submit -->
    <div class="alert alert-success mb-4">
        <h2>Empfangene Daten:</h2>
        <ul>
            <li><strong>Pflichtfeld Text:</strong> <?php echo $POSTARRAY['pflichtfelttext']; ?></li>
            <li><strong>Nicht-Pflichtfeld Text:</strong> <?php echo $POSTARRAY['nopflichtfelttext']; ?></li>
            <li><strong>Telefon:</strong> <?php echo $POSTARRAY['telefon']; ?></li>
            <li><strong>PLZ:</strong> <?php echo $POSTARRAY['plz']; ?></li>
            <li><strong>Geburtstag:</strong> <?php echo $POSTARRAY['Geburtstag']; ?></li>
            <li><strong>E-Mail:</strong> <?php echo $POSTARRAY['email1']; ?></li>
            <li><strong>E-Mail bestätigen:</strong> <?php echo $POSTARRAY['email2']; ?></li>
            <li><strong>Radiobutton-Auswahl:</strong> <?php echo $POSTARRAY['radios']; ?></li>
            <li><strong>Checkbox-Auswahl:</strong> <?php echo implode(", ", $POSTARRAY['checks']); ?></li>
            <li><strong>Langtexte:</strong> <?php echo nl2br($POSTARRAY['Langtexte']); ?></li>
            <li><strong>Dropdown-Auswahl:</strong> <?php echo $POSTARRAY['selectdropdown']; ?></li>
        </ul>
        <a href="test-form-validations.php" class="btn btn-primary">Zurück zum Formular</a>
    </div>
    <?php endif; ?>
    
    <?php if (!$showResults): ?>
    <!-- Das eigentliche Formular -->
    <form id="formins" method="post" action="" novalidate>
        <fieldset>
            <legend>Testformular mit Validierungen</legend>
            
            <!-- Pflichtfeld Text -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required" for="pflichtfelttext">Pflichtfeld Text</label>
                <div class="col-sm-8">
                    <input id="pflichtfelttext" name="pflichtfelttext" class="form-control required element text" type="text" value="<?php echo $POSTARRAY['pflichtfelttext']; ?>" />
                </div>
            </div>
            
            <!-- Nicht-Pflichtfeld Text -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label" for="nopflichtfelttext">Nicht-Pflichtfeld Text</label>
                <div class="col-sm-8">
                    <input id="nopflichtfelttext" name="nopflichtfelttext" class="form-control element text" type="text" value="<?php echo $POSTARRAY['nopflichtfelttext']; ?>" />
                </div>
            </div>
            
            <!-- Telefonnummer (mit Validierung) -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required" for="telefon">Telefonnummer</label>
                <div class="col-sm-8">
                    <input id="telefon" name="telefon" class="form-control required element text" type="text" value="<?php echo $POSTARRAY['telefon']; ?>" />
                    <small class="form-text text-muted">Gültig: Ziffern, Leerzeichen und ein + am Anfang (Bsp: +49 123 4567890)</small>
                </div>
            </div>
            
            <!-- PLZ (mit Validierung) -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required" for="plz">Postleitzahl</label>
                <div class="col-sm-8">
                    <input id="plz" name="plz" class="form-control required element text" type="text" value="<?php echo $POSTARRAY['plz']; ?>" />
                    <small class="form-text text-muted">Muss genau 5 Ziffern enthalten</small>
                </div>
            </div>
            
            <!-- Geburtstag (mit Datums-Validierung) -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required" for="Geburtstag">Geburtstag</label>
                <div class="col-sm-8">
                    <input id="Geburtstag" name="Geburtstag" class="form-control required element date" type="date" value="<?php echo $POSTARRAY['Geburtstag']; ?>" />
                </div>
            </div>
            
            <!-- E-Mail (mit Validierung) -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required" for="email1">E-Mail</label>
                <div class="col-sm-8">
                    <input id="email1" name="email1" class="form-control required element email" type="email" value="<?php echo $POSTARRAY['email1']; ?>" />
                </div>
            </div>
            
            <!-- E-Mail Bestätigung (mit Übereinstimmungsvalidierung) -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required" for="email2">E-Mail bestätigen</label>
                <div class="col-sm-8">
                    <input id="email2" name="email2" class="form-control required element email" type="email" value="<?php echo $POSTARRAY['email2']; ?>" />
                    <small class="form-text text-muted">Muss mit der E-Mail oben übereinstimmen</small>
                </div>
            </div>
            
            <!-- Radio-Buttons (mindestens einer muss ausgewählt sein) -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required">Radiobuttons Auswahl</label>
                <div class="col-sm-8">
                    <div class="form-check form-check-inline">
                        <input id="radios_1" name="radios" class="form-check-input required element radio" type="radio" value="Option 1" <?php if ($POSTARRAY['radios'] == 'Option 1') { echo 'checked="checked"'; } ?> />
                        <label class="form-check-label" for="radios_1">Option 1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="radios_2" name="radios" class="form-check-input required element radio" type="radio" value="Option 2" <?php if ($POSTARRAY['radios'] == 'Option 2') { echo 'checked="checked"'; } ?> />
                        <label class="form-check-label" for="radios_2">Option 2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="radios_3" name="radios" class="form-check-input required element radio" type="radio" value="Option 3" <?php if ($POSTARRAY['radios'] == 'Option 3') { echo 'checked="checked"'; } ?> />
                        <label class="form-check-label" for="radios_3">Option 3</label>
                    </div>
                </div>
            </div>
            
            <!-- Checkboxen (mindestens eine muss ausgewählt sein) -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required">Checkboxen Auswahl</label>
                <div class="col-sm-8">
                    <div class="form-check form-check-inline">
                        <input id="checks_1" name="checks[]" class="form-check-input required element checkbox" type="checkbox" value="Check 1" <?php echo isChecked('Check 1', $POSTARRAY['checks']); ?> />
                        <label class="form-check-label" for="checks_1">Check 1</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="checks_2" name="checks[]" class="form-check-input required element checkbox" type="checkbox" value="Check 2" <?php echo isChecked('Check 2', $POSTARRAY['checks']); ?> />
                        <label class="form-check-label" for="checks_2">Check 2</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input id="checks_3" name="checks[]" class="form-check-input required element checkbox" type="checkbox" value="Check 3" <?php echo isChecked('Check 3', $POSTARRAY['checks']); ?> />
                        <label class="form-check-label" for="checks_3">Check 3</label>
                    </div>
                </div>
            </div>
            
            <!-- Textarea (Pflichtfeld) -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required" for="Langtexte">Langtexte</label>
                <div class="col-sm-8">
                    <textarea id="Langtexte" name="Langtexte" class="form-control required element textarea"><?php echo $POSTARRAY['Langtexte']; ?></textarea>
                </div>
            </div>
            
            <!-- Select-Dropdown -->
            <div class="form-row mb-3">
                <label class="col-sm-3 col-form-label required" for="selectdropdown">Dropdown Auswahl</label>
                <div class="col-sm-8">
                    <select id="selectdropdown" name="selectdropdown" class="form-control required element select">
                        <option value="">Bitte auswählen</option>
                        <option value="Option1" <?php if ($POSTARRAY['selectdropdown'] == 'Option1') { echo 'selected="selected"'; } ?>>Option1</option>
                        <option value="Option2" <?php if ($POSTARRAY['selectdropdown'] == 'Option2') { echo 'selected="selected"'; } ?>>Option2</option>
                        <option value="Option3" <?php if ($POSTARRAY['selectdropdown'] == 'Option3') { echo 'selected="selected"'; } ?>>Option3</option>
                    </select>
                </div>
            </div>
            
            <!-- Submit-Button -->
            <div class="form-row mb-3">
                <div class="col-sm-3"></div>
                <div class="col-sm-8">
                    <button type="button" onclick="submitclick()" class="btn btn-primary">Formular absenden</button>
                </div>
            </div>
        </fieldset>
    </form>
    
    <!-- Zusätzliche JavaScript für die spezifische Validierung -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Telefonnummer-Validierung
        const telefonField = document.getElementById('telefon');
        telefonField.addEventListener('blur', function() {
            if (this.value.trim()) {
                const telefonRegex = /^[+]?[0-9 ]+$/;
                if (!telefonRegex.test(this.value.trim())) {
                    showError(this, 'Die Telefonnummer darf nur Ziffern, Leerzeichen und ein + am Anfang enthalten.');
                }
            }
        });
        
        // PLZ-Validierung
        const plzField = document.getElementById('plz');
        plzField.addEventListener('blur', function() {
            if (this.value.trim()) {
                const plzRegex = /^\d{5}$/;
                if (!plzRegex.test(this.value.trim())) {
                    showError(this, 'Die Postleitzahl muss genau 5 Ziffern enthalten.');
                }
            }
        });
        
        // E-Mail-Übereinstimmung
        const email2Field = document.getElementById('email2');
        email2Field.addEventListener('blur', function() {
            if (this.value.trim()) {
                const email1Value = document.getElementById('email1').value;
                if (this.value !== email1Value) {
                    showError(this, 'Die E-Mail-Adressen müssen übereinstimmen.');
                }
            }
        });
        
        // Geburtsdatum-Validierung
        const birthdateField = document.getElementById('Geburtstag');
        birthdateField.addEventListener('blur', function() {
            if (this.value.trim()) {
                const birthDate = new Date(this.value);
                
                // Validiere, dass das Datum nicht in der Zukunft liegt
                const today = new Date();
                if (birthDate > today) {
                    showError(this, 'Das Geburtsdatum darf nicht in der Zukunft liegen.');
                    return;
                }
                
                // Berechne das Alter zum aktuellen Datum
                const yearDiff = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                const dayDiff = today.getDate() - birthDate.getDate();
                let age = yearDiff;
                
                // Berücksichtige den Monat und Tag für die genaue Altersberechnung
                if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                    age--;
                }
            }
        });
    });
    
    // Erweitere die validateForm-Funktion um spezifische Validierungen
    const originalValidateForm = validateForm;
    validateForm = function() {
        let formValid = originalValidateForm();
        
        // Prüfe PLZ-Format
        const plzField = document.getElementById('plz');
        if (plzField && plzField.value.trim()) {
            const plzRegex = /^\d{5}$/;
            if (!plzRegex.test(plzField.value.trim())) {
                formValid = false;
                showError(plzField, 'Die Postleitzahl muss genau 5 Ziffern enthalten.');
            }
        }
        
        // Prüfe Telefonnummer-Format
        const telefonField = document.getElementById('telefon');
        if (telefonField && telefonField.value.trim()) {
            const telefonRegex = /^[+]?[0-9 ]+$/;
            if (!telefonRegex.test(telefonField.value.trim())) {
                formValid = false;
                showError(telefonField, 'Die Telefonnummer darf nur Ziffern, Leerzeichen und ein + am Anfang enthalten.');
            }
        }
        
        // Prüfe E-Mail-Übereinstimmung
        const email1Field = document.getElementById('email1');
        const email2Field = document.getElementById('email2');
        if (email1Field && email2Field && email1Field.value.trim() && email2Field.value.trim()) {
            if (email1Field.value !== email2Field.value) {
                formValid = false;
                showError(email2Field, 'Die E-Mail-Adressen müssen übereinstimmen.');
            }
        }
        
        // Prüfe mindestens eine Checkbox ausgewählt
        const checkboxes = document.querySelectorAll('input[name="checks[]"]');
        let checksValid = false;
        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                checksValid = true;
            }
        });
        
        if (!checksValid) {
            formValid = false;
            showError(checkboxes[0], 'Bitte wählen Sie mindestens eine Option aus.');
        }
        
        return formValid;
    };
    </script>
    <?php endif; ?>
</div>

</body>
</html>
