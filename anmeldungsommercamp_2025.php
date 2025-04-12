<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

?>
<?php
// Diese Variable ist jetzt immer false, da wir jQuery nicht mehr verwenden
$usejquery = false;
$usesheepit = false;
$showform = false;

$selectedida = 0;
$selectedvuelta = 0;
$selectedvuelta2 = 0;

// Initialisierung der globalen Variablen, die später verwendet werden
// Vollständiges $POSTARRAY mit allen möglichen Schlüsseln initialisieren
$POSTARRAY = array(
    'MfirstName' => '',
    'MlastName' => '',
    'M_DNI' => '',
    'PfirstName' => '',
    'PlastName' => '',
    'P_DNI' => '',
    'Street' => '',
    'Town' => '',
    'PLZ' => '',
    'Phone' => '',
    'phone0' => '',
    'Email1' => '',
    'Email2' => '',
    'nombre0' => '',
    'apellidos0' => '',
    'birthdate0' => '',
    'dsb0' => '',
    'colegio0' => '',
    'nadar0' => '',
    'autohinch0' => '',
    'autopisci0' => '',
    'autopisci00' => '', // Fehlender Schlüssel
    'alergias0' => '',
    'intolerancias0' => '',
    'medicaciones0' => '',
    'idioma0' => '',
    'obsidioma0' => '',
    'infoKursFundort' => '',
    'famIDMulti' => '',
    'Busida' => 'SIN AUTOBUS',
    'Busvuelta' => 'SIN AUTOBUS',
    'Busvuelta2' => 'SIN AUTOBUS'
);

// Arrays für die Wochen-Optionen initialisieren
$weekchecks = array('', '', '', '', '', '');
$fruehchecks = array('', '', '', '', '', '');
$mittagchecks = array('', '', '', '', '', '');
$nr = 0; // Initialisierung von $nr

require_once 'includes/headbody_2025.php';
require_once 'includes/cursossemanasprecios_2025.php';
$uniqueID = md5(uniqid(mt_rand(), true));
?>

<!-- DSB Logo & Style -->
<link rel="stylesheet" href="css/dsbform_2.css">

<!-- Verbesserte Validierungsstile -->
<link rel="stylesheet" href="css/validation-styles_2.css">

<!-- Reine JavaScript-Validierung -->
<script src="js/pure-validation.js"></script>

<!-- Reine JavaScript-Funktionen, die jQuery ersetzen -->
<script src="js/js-functions.js"></script>

<!-- Initialisierung der JavaScript-Variablen für die Preisberechnung -->
<script>
    // Preise für verschiedene Wochen und Rabatte
    <?php
    for ($i = 1; $i <= 6; $i++) {
        for ($j = 1; $j <= 4; $j++) {
            echo "cursoprecio_{$i}_{$j} = " . $cursoprecio[$i][$j] . ";\n";
        }
    }
    ?>
    
    // Preise für Frühbetreuung
    <?php
    for ($i = 1; $i <= 5; $i++) {
        echo "fruehcursoprecio_{$i} = " . $fruehcursoprecio[$i] . ";\n";
    }
    ?>
    
    // Preise für Mittagsbetreuung
    <?php
    for ($i = 1; $i <= 5; $i++) {
        echo "mittagcursoprecio_{$i} = " . $mittagcursoprecio[$i] . ";\n";
    }
    ?>
    
    // Label-Texte für Wochen
    <?php
    for ($i = 1; $i <= 5; $i++) {
        echo "weekLabel{$i} = \"" . $week[$i] . "&nbsp;(Precio \";\n";
    }
    ?>
</script>

<!-- Sofortige Entfernung aller Fehler-Icons ohne auf DOM Ready zu warten -->
<script>
    // Entferne alte Validierungsanzeigen
    document.addEventListener('DOMContentLoaded', function(event) {
        // Direkte DOM-Manipulation
        var errorElements = document.querySelectorAll('.errorImage, .errorimage, .validation-container, .validationContainer');
        for (var i = 0; i < errorElements.length; i++) {
            if (errorElements[i].parentNode) {
                errorElements[i].parentNode.removeChild(errorElements[i]);
            }
        }
    });
</script>

<?php
include_once("includes/fieldnames_2025.php");

if (sizeof($_POST) > 0 || sizeof($_FILES) > 0) {
	$kurs_woche0 = array('0');
	$kursoptions0 = array('0');
	$IsChecked = array();
	$IsChecked[] = array(0, 1, 2, 3, 4, 5, 6); //zweidimensional

	$POSTARRAY = decode_arr($_POST['encryptedpost']);
	if ($_POST['encryptedkurs_woche0'] <> '0') $kurs_woche = decode_arr($_POST['encryptedkurs_woche0']);
	if ($_POST['encryptedkurs_options0'] <> '0') $kursoptions = decode_arr($_POST['encryptedkurs_options0']);

	// Loop through source array
	foreach ($kurs_woche as $element) {
		// Extract the type (f or m) and index (numeric part) from the element
		$type = substr($element, 0, 1);
		$index = (int)substr($element, 1);

		// Set the corresponding element in the destination arrays based on the type and index
		if ($type === 'w') {
			$weekchecks[$index] = 'checked';
		}
	}

	// Loop through source array
	foreach ($kursoptions as $element) {
		// Extract the type (f or m) and index (numeric part) from the element
		$type = substr($element, 0, 1);
		$index = (int)substr($element, 1);

		// Set the corresponding element in the destination arrays based on the type and index
		if ($type === 'f') {
			$fruehchecks[$index] = 'checked';
		} elseif ($type === 'm') {
			$mittagchecks[$index] = 'checked';
		}
	}


	$nrrs = array('0', '1', '2', '3', '4');

	$selectedvuelta = $POSTARRAY['Busvuelta'];
	$selectedvuelta2 = $POSTARRAY['Busvuelta2'];
	$selectedida = $POSTARRAY['Busida'];
	//echo "<h1>Neu:".$_POST['NeuerSchueler']."</h1>";
	if (isset($_POST['NeuerSchueler']) && $_POST['NeuerSchueler'] === 'X') { //wenn nexter schueler
		//$POSTARRAY['apellidos0'];
		$POSTARRAY['nombre0'] = "";
		$POSTARRAY['birthdate0'] = "";
		$POSTARRAY['dsb0'] = "";
		$POSTARRAY['colegio0'] = "";
		$POSTARRAY['nadar0'] = '';
		$POSTARRAY['autohinch0'] = '';
		$POSTARRAY['autopisci0'] = '';
		$POSTARRAY['alergias0'] = '';
		$POSTARRAY['intolerancias0'] = '';
		$POSTARRAY['medicaciones0'] = '';
		$POSTARRAY['idioma0'] == '';
		$POSTARRAY['obsidioma0'] = '';
	}
?>


	<!-- Initialisierung mit reinem JavaScript statt jQuery -->
	<script type="text/javascript">
		document.addEventListener('DOMContentLoaded', function() {
			// DSB Student Radiobutton-Status prüfen
			if (document.getElementById('dsb0_1') && document.getElementById('dsb0_1').checked) {
				dsbclicksi('0');
			} else if (document.getElementById('dsb0_2') && document.getElementById('dsb0_2').checked) {
				dsbclickno('0');
			}
			
			// Wochenoptionen anzeigen/verbergen basierend auf dem Checked-Status
			for (var weeknr = 1; weeknr < 7; weeknr++) {
				var cursoElement = document.getElementById('curso0-' + weeknr);
				if (cursoElement && cursoElement.checked) {
					var zoption1 = document.getElementById('zoption0-' + weeknr + '-1');
					var zoption2 = document.getElementById('zoption0-' + weeknr + '-2');
					var zoption3 = document.getElementById('zoption0-' + weeknr + '-3');
					var tdcurso = document.getElementById('tdcurso-0-' + weeknr + '-0');
					var tdoption1 = document.getElementById('tdoption-0-' + weeknr + '-1');
					var tdoption2 = document.getElementById('tdoption-0-' + weeknr + '-2');
					var tdoption3 = document.getElementById('tdoption-0-' + weeknr + '-3');
					
					if (zoption1) zoption1.style.display = '';
					if (zoption2) zoption2.style.display = '';
					if (zoption3) zoption3.style.display = '';
					if (tdcurso) tdcurso.style.display = '';
					if (tdoption1) tdoption1.style.display = '';
					if (tdoption2) tdoption2.style.display = '';
					if (tdoption3) tdoption3.style.display = '';
				}
			}
		});
	</script>
<?php } // end if $_POST
require_once 'includes/dropdownparadas_2025.php';
?>
<!--  <p><?php echo $uniqueID; ?></p> -->

<div class="asp col-12">

	<!--
<div style="text-align:right;">&nbsp;<br /><a href="/" target="_parent">
            Vers?n mobile <i class="fa fa-mobile" aria-hidden="true"></i></a> |
     <a href="/" target="_parent">
            Vers?n ordenador <i class="fas fa-desktop"></i></a><br />&nbsp;
</div>-->


	<form id="formins" class="form-inlineX needs-validation" novalidate method="post" action="aceptar-inscripcion.php">

		<fieldset>
			<div class="form-row">
				<label class="required">Los campos marcados con <span style="color: var(--colorHex-dsbBlue);">&#9733;</span> son obligatorios</label>
			</div>


			<div class="legend">Madre o tutor/a 1:</div>

			<input type="hidden" id="uniqueID" name="uniqueID" value="<?php echo $uniqueID ?>" />

			<div class="form-row">
				<label required class="col-sm-3 col-form-label required" for="MfirstName"> Nombre <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="MfirstName" name="MfirstName" size="45" value="<?php echo $POSTARRAY['MfirstName']; ?>" />
				</div>
			</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="MlastName">Apellidos <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="MlastName" name="MlastName" size="45" value="<?php echo $POSTARRAY['MlastName']; ?>" />
				</div>
			</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="M_DNI">DNI / NIE <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="M_DNI" name="M_DNI" size="14" value="<?php echo $POSTARRAY['M_DNI']; ?>" />
				</div>
			</div>

			<div class="legend">Padre o tutor/a 2:</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="PfirstName">Nombre <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="PfirstName" name="PfirstName" size="45" value="<?php echo $POSTARRAY['PfirstName']; ?>" />
				</div>
			</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="PlastName">Apellidos <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="PlastName" name="PlastName" size="45" value="<?php echo $POSTARRAY['PlastName']; ?>" />
				</div>
			</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="P_DNI">DNI / NIE <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="P_DNI" name="P_DNI" size="14" value="<?php echo $POSTARRAY['P_DNI']; ?>" />
				</div>
			</div>


			<div class="legend">Direcci&oacute;n, contacto:</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="Street">Direcci&oacute;n (calle y n&uacute;meros) <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="Street" name="Street" size="45" value="<?php echo $POSTARRAY['Street']; ?>" />
				</div>
			</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="Town">Poblaci&oacute;n <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="Town" name="Town" size="45" value="<?php echo $POSTARRAY['Town']; ?>" />
				</div>
			</div>
			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="PLZ">C&oacute;digo Postal <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" type="text" id="PLZ" name="PLZ" size="8" value="<?php echo $POSTARRAY['PLZ']; ?>" pattern="[0-9]{5}" title="Bitte geben Sie eine 5-stellige Postleitzahl ein" />
				</div>
			</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="Phone">Tel&eacute;fono <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required digits" type="tel" id="Phone" name="Phone" size="16" value="<?php echo $POSTARRAY['Phone']; ?>" pattern="[+0-9 ]+" title="Nur Ziffern, Leerzeichen und + am Anfang erlaubt" />
				</div>
			</div>


			<div class="form-row">
				<label class="col-sm-3 col-form-label" for="phone0">Tel&eacute;fono adicional</label>
				<div class="col-sm-8">
					<input class="digits" type="tel" id="phone0" name="phone0" size="16" value="<?php echo $POSTARRAY['phone0']; ?>" pattern="[+0-9 ]+" title="Nur Ziffern, Leerzeichen und + am Anfang erlaubt" />
				</div>
			</div>


			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="Email1">Correo electr&oacute;nico <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required email" type="email" id="Email1" name="Email1" size="45" value="<?php echo $POSTARRAY['Email1']; ?>" />
				</div>
			</div>
			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="Email2">Repetir correo electr&oacute;nico <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required email" type="email" id="Email2" name="Email2" size="45" value="<?php echo $POSTARRAY['Email2']; ?>" data-match="Email1" />
				</div>
			</div>

			<div class="legend">
				<p>Transporte gratis:</p>
			</div>
			<p><em>Se puede utilizar distintas líneas de autobús y distintas paradas de autobús en ida y vuelta. 
				Están garantizadas las paradas elegidas en la inscripción, siempre que haya un número suficiente de alumnos para crear un recorrido que incluya estas paradas elegidas. 
				No podemos prever el horario de la parada, ni la ruta, ya que será organizado una vez recibidas todas las inscripciones. Esto requiere cierta 
				flexibilidad por su parte, ya que el horario de la parada elegida podría variar. 
				
En <a href="https://www.dsbilbao.org/cursos-de-idiomas/campus-de-verano/transporte/" target="_new"> Horarios de autobús  </a>
se pueden ver los recorridos en el Campus de verano 2024 con carácter orientativo. </em></p>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="Busida">Bus ida <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<?php echo $optionsida; ?>
				</div>
			</div>
			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="Busvuelta">Bus vuelta 13:45<sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<?php echo $optionsvuelta; ?>
				</div>
			</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="Busvuelta2">Bus vuelta 16:15 <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<?php echo $optionsvuelta2; ?>
				</div>
			</div>



			<div class="Mainlegend">Alumno/a:<!--Ni?o(s)--></div>

			<!--<hr/>
    <div class="legend">Hijo/a <span id="person_addresses_label"></span></div>-->

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="nombre0">Nombre <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" id="nombre0" name="nombre0" type="text" size="45" value="<?php echo $POSTARRAY['nombre0']; ?>" />
				</div>
			</div>

			<div class="form-row">
				<label class="col-sm-3 col-form-label required" for="apellidos0">Apellidos <sup>&#9733;</sup></label>
				<div class="col-sm-8">
					<input class="required" id="apellidos0" name="apellidos0" type="text" size="45" value="<?php echo $POSTARRAY['apellidos0']; ?>" />
				</div>
			</div>



			<div class="form-row">
				<label class="col-sm-4 col-form-label required" for="birthdate0">Fecha de nacimiento <sup>&#9733;</sup></label>
				<div class="col-sm-6">
					<input class="required dateDEU" id="birthdate0" name="birthdate0" type="date" size="10" value="<?php echo $POSTARRAY['birthdate0']; ?>" style="height:2em;min-height:2em;line-height:2em;width:12em" />
				</div>
			</div>

			<div class="form-row mb-3">
				<label class="col-auto col-form-label required description1">&iquest;Es actualmente alumno/a del DSB? <sup>&#9733;</sup></label>
				<div class="col-auto">

					<div class="form-check form-check-inline">
						<input id="dsb0_1" name="dsb0" class="form-check-input required element radio" type="radio" value="Si" onclick="dsbclicksi('0')" <?php if ($POSTARRAY['dsb0'] == 'Si') { ?>checked="checked" <?php } ?> />
						<label class="form-check-label" for="dsb0_1">si</label>
					</div>

					<div class="form-check form-check-inline">
						<input id="dsb0_2" name="dsb0" class="form-check-input required element radio" type="radio" value="No" onclick="dsbclickno('0')" <?php if (($POSTARRAY['dsb0'] !== 'Si') and ($POSTARRAY['dsb0'] !== '') and ($POSTARRAY['dsb0'])) {
																																								echo 'checked="checked"';
																																							} ?> />
						<label class="form-check-label" for="dsb0_2">no</label>
					</div>

				</div>
				<div>
					<div id="divlabelcolegio0" style="white-space:nowrap;">
						<label class="float description1 col-form-label required" id="labelcolegio0" for="colegio0">&nbsp;Colegio habitual <sup>&#9733;</sup></label>
						<input class="required" id="colegio0" name="colegio0" type="text" size="24" maxlength="100" value="<?php echo $POSTARRAY['colegio0']; ?>" onclick="colegioclick('0')" />
					</div>

				</div>
			</div>

			<!-- xxxxxxxxxxxxxxxxx -->


			<div class="form-row mb-3">
				<label class="labelYesNo col-auto required">&iquest;Sabe nadar sin ayuda? <sup>&#9733;</sup></label>
				<div class="col-auto">

					<div class="form-check form-check-inline">
						<input id="nadar0_1" name="nadar0" class="form-check-input  required element radio" type="radio" value="Si" <?php if ($POSTARRAY['nadar0'] == 'Si') { ?>checked="checked" <?php } ?> />
						<label class="form-check-label" for="nadar0_1">si</label>
					</div>

					<div class="form-check form-check-inline">
						<input id="nadar0_2" name="nadar0" class="form-check-input  required element radio" type="radio" value="No" <?php if (($POSTARRAY['nadar0'] !== 'Si') and ($POSTARRAY['nadar0'] !== '') and ($POSTARRAY['nadar0'])) { ?>checked="checked" <?php } ?> />
						<label class="form-check-label" for="nadar0_2">no</label>
					</div>

				</div>
			</div>


			<div class="form-row mb-3">
				<label class="labelYesNo col-auto required">&iquest;Tiene autorizaci&oacute;n para ba&ntilde;arse en las piscinas hinchables infantiles bajo la supervisi&oacute;n del profesor/a? <sup>&#9733;</sup></label>
				<div class="col-auto">
					<div class="form-check form-check-inline">
						<input id="autohinch0_1" name="autohinch0" class="form-check-input  required  element radio" type="radio" value="Si" <?php if ($POSTARRAY['autohinch0'] == 'Si') { ?>checked="checked" <?php } ?> />
						<label class="form-check-label" for="autohinch0_1">si</label>&nbsp;&nbsp;
					</div>
					<div class="form-check form-check-inline">
						<input id="autohinch0_2" name="autohinch0" class="form-check-input  required element radio" type="radio" value="No" <?php if (($POSTARRAY['autohinch0'] !== 'Si') and ($POSTARRAY['autohinch0'] !== '') and ($POSTARRAY['autohinch0'])) { ?>checked="checked" <?php } ?> />
						<label class="form-check-label" for="autohinch0_2">no</label>
					</div>
				</div>
			</div>



			<div class="form-row mb-3">
				<label class="labelYesNo col-auto required">&iquest;Tiene autorizaci&oacute;n para ba&ntilde;arse en la piscina grande bajo la supervisi&oacute;n
					del <span class="labelYesNo" style="width: 500px;">socorrista</span>?<sup><em> </em>&#9733;</sup></label>
				<div class="col-auto">

					<div class="form-check form-check-inline">

						<input id="autopisci0_1" name="autopisci0" class="form-check-input element  required radio" type="radio" value="Si" <?php if ($POSTARRAY['autopisci0'] == 'Si') { ?>checked="checked" <?php } ?> />
						<label class="form-check-label" for="autopisci0_1">si</label>&nbsp;&nbsp;
					</div>

					<div class="form-check form-check-inline">
						<input id="autopisci0_2" name="autopisci0" class="form-check-input element required radio" type="radio" value="No" <?php if (($POSTARRAY['autopisci0'] !== 'Si') and ($POSTARRAY['autopisci0'] !== '') and ($POSTARRAY['autopisci0'])) { ?>checked="checked" <?php } ?> />
						<label class="form-check-label" for="autopisci0_2">no</label>
					</div>

				</div>
			</div>
			<!-- xxxxxxxxxxxxxxxxx -->

			<div class="form-row" style="clear:both;">
				<label class="col-sm-3 col-form-label not-required" for="alergias0">Alergias </label>
				<input id="alergias0" name="alergias0" type="text" size="45" maxlength="100" value="<?php echo $POSTARRAY['alergias0']; ?>" />
			</div>


			<div class="form-row">
				<label class="col-sm-3 col-form-label not-required" for="intolerancias0">Intolerancias a alimentos </label>
				<input id="intolerancias0" name="intolerancias0" type="text" size="45" maxlength="100" value="<?php echo $POSTARRAY['intolerancias0']; ?>" />
			</div>


			<div class="form-row mb-2">
				<label class="col-sm-3 col-form-label not-required" for="medicaciones0">Medicaciones </label>
				<input id="medicaciones0" name="medicaciones0" type="text" size="45" maxlength="100" value="<?php echo $POSTARRAY['medicaciones0']; ?>" />
			</div>

			<?php //optionen sind fr alle gewhlten Wochen gltig 
			/*
					    echo "<p>isChecked[0]: ";
						print_r($kurs_woche);	
	    				echo " | end of isChecked[0]</p>";

					    echo "<p>weekchecks: ";
						print_r($weekchecks);	
	    				echo " | end of weekchecks</p>";

	
	
	                    echo "<p>kursoptions: ";
						print_r($kursoptions);	
	    				echo " | kursoptions</p>";
	
					    echo "<p>fruehchecks: ";
						print_r($fruehchecks);	
	    				echo " | fruehchecks</p>";
					    
	                    echo "<p>mittagchecks: ";
						print_r($mittagchecks);	
	    				echo " | mittagchecks</p>";
	
				*/
			?>



			<div class="selectcurso" id="Kursbox" width="100%">
				<div class="subheader">Curso <span id="JUNG" style="display:none">a</span> <span id="XALT" style="display:none">b</span> - Precio final <span id="precio">0</span> </div>
				<div class="field1 extraspace form-row" style="margin-top:0.5em">
					<label class="labelYesNo col-auto bigger required" style="width:5em;text-align:right">Idioma&nbsp;<sup>&#9733;</sup></label>

					<div class="col-auto">
						<div class="form-check form-check-inline">
							<!-- <p><?php echo substr($POSTARRAY['idioma0'], 0, 1) ?></p> -->
							<input id="idioma0_2" name="idioma0" class="form-check-input element radio required" type="radio" value="Ingl&eacute;s" onclick="idiomaclick('0')" <?php if (substr($POSTARRAY['idioma0'], 0, 1) == 'I') { ?>checked="checked" <?php } ?> />
							<label class="form-check-label" for="idioma0_2"><strong>Ingl&eacute;s</strong></label>
						</div>

						<div class="form-check form-check-inline">

							<input id="idioma0_1" name="idioma0" class="form-check-input element radio required" type="radio" value="Alem&aacute;n" onclick="idiomaclick('0')" <?php if (substr($POSTARRAY['idioma0'], 0, 1) == 'A') { ?>checked="checked" <?php } ?> />
							<label class="form-check-label" for="idioma0_1"><strong>Alem&aacute;n</strong></label>

						</div>


						<div class="form-check form-check-inline">

							<input id="idioma0_3" name="idioma0" class="form-check-input element radio required" type="radio" value="Franc&eacute;s" onclick="idiomaclick('0')" <?php if (substr($POSTARRAY['idioma0'], 0, 1) == 'F') { ?>checked="checked" <?php } ?> />
							<label class="form-check-label" for="idioma0_3"><strong>Franc&eacute;s</strong></label>

						</div>


						<div class="form-check form-check-inline">

							<input id="idioma0_4" name="idioma0" class="form-check-input element radio required" type="radio" value="Espa&ntilde;ol" onclick="idiomaclick('0')" <?php if (substr($POSTARRAY['idioma0'], 0, 1) == 'E') { ?>checked="checked" <?php } ?> />
							<label class="form-check-label" for="idioma0_4"><strong>Espa&ntilde;ol</strong></label>

						</div>



						<div class="form-check form-check-inline">

							<input id="idioma0_5" name="idioma0" class="form-check-input element radio required" type="radio" value="Ruso" onclick="idiomaclick('0')" <?php if (substr($POSTARRAY['idioma0'], 0, 1) == 'R') { ?>checked="checked" <?php } ?> />
							<label class="form-check-label" for="idioma0_5"><strong>Ruso</strong></label>

						</div>						



					</div>
				</div>




				<div>
					<label class="labelYesNo required">Elijan las semanas en las que el alumno/la alumna asistir&aacute; al campus de verano.<sup>&#9733;</sup></label>


					<div id="cursos">
						<table class="table table-striped options">
							<thead>
							<tbody>
								<?php





								for ($idx = 0; $idx < 4; $idx++) { //die 4 wochen

									$idx1 = $idx + 1;
									if (!($cursovalue[$idx1] == "")) { ?>
										<tr>
											<td class="tdflex"><label class="form-check-label dsbcheckbox" for="curso0-<?php echo $idx1; ?>" style="width:200px;">
													<input class="kursgroup required" id="curso0-<?php echo $idx1; ?>" name="curso0[]" type="checkbox" <?php echo $weekchecks[$idx1]; ?> onclick="weekclick(<?php echo $idx1; ?>);" value="w<?php echo $idx1; ?>" />
													<span id="labweek<?= $idx1 ?>"><?php echo $week[$idx1] . '&nbsp;(Precio: ' . $cursoprecio[$idx1][1] . '&euro;)'; ?> <br></span>
												</label>
												<label id="lab_fruehcurso0-<?php echo $idx1; ?>" class="form-check-label dsbcheckbox" for="fruehcurso0-<?php echo $idx1; ?>">
													<input class="kursgroup" id="fruehcurso0-<?php echo $idx1; ?>" name="zoption0-week[]" type="checkbox" <?php echo $fruehchecks[$idx1]; ?> onclick="weekclick(<?php echo $idx1; ?>);" value="f<?php echo $idx1; ?>" />
													<span class="weekoption">&nbsp;<?php echo $fruehoption . '&nbsp;(' . $fruehcursoprecio[$idx1] . '&euro;)'; ?> <br></span>
												</label>
												<label id="lab_mittagcurso0-<?php echo $idx1; ?>" class="form-check-label dsbcheckbox" for="mittagcurso0-<?php echo $idx1; ?>">
													<input class="kursgroup" id="mittagcurso0-<?php echo $idx1; ?>" name="zoption0-week[]" type="checkbox" <?php echo $mittagchecks[$idx1]; ?> onclick="weekclick(<?php echo $idx1; ?>);" value="m<?php echo $idx1; ?>" />
													<span class="weekoption">&nbsp;<?php echo $mittagoption . '&nbsp;(' . $mittagcursoprecio[$idx1] . '&euro;)'; ?> <br></span>
												</label>

											</td>
										</tr><?php }
										} ?>
							</tbody>
						</table>


					</div>



				</div>


				<div class="clearl form-check field1">
					<label class="col-form-label required description1" for="obsidioma0">Observaciones con respecto al nivel en el idioma <sup>&#9733;</sup></label>
					<div>
						<textarea id="obsidioma0" name="obsidioma0" class="required element textarea medium col-sm-8"><?php echo $POSTARRAY['obsidioma0'] ?></textarea>
					</div>
				</div>

				</div>




				<div id="UmfrageActividades" style="margin-left:2em;">

					<div class="form-row" style="clear:both;">
						<label style="text-align:left!important;width:100%" class="col-form-label col-auto required" for="infoKursFundort">Ind&iacute;quenos c&oacute;mo han conocido nuestra oferta de los campus de verano en el Colegio Alem&aacute;n&nbsp; <sup>&#9733;</sup></label>
						<div>
						<input class="required w-100" validate="required:true" id="infoKursFundort" name="infoKursFundort" type="text" size="40" maxlength="120" value="<?php echo $POSTARRAY['infoKursFundort']; ?>" />
						</div>
					</div>

					<input validate="required:false" id="famIDMulti" name="famIDMulti" type="hidden" size="12" maxlength="12" value="<?php echo $POSTARRAY['famIDMulti']; ?>" />
				</div><!--end div Umfrage-->


				<div class="Mainlegend">Validar formulario:</div>
				<div style="text-align:center;margin-top:1em;">
					<div class="row mb-4 mt-4">
						<div class="col-12 text-right">
							<button type="button" class="btn btn-dsb" onclick="if (submitclick()) document.getElementById('formins').submit();">Pr&oacute;xima p&aacute;gina</button>
						</div>
					</div>
				</div>

				<p class="dstdc">En la pr&oacute;xima p&aacute;gina se podr&aacute; controlar los datos, se ver&aacute; el precio total y se podr&aacute; confirmar la inscripci&oacute;n.</p>

				<div class="form-check form-check-inline field1">
					<hr />
				</div>


		</fieldset>


	</form>
</div>


<!--    Datum der letzten Aenderung     -->
<?php require_once 'includes/footer.php'; ?>

<!-- 
    Die Validierung erfolgt jetzt komplett über reines JavaScript in der Datei pure-validation.js
    ohne Abhängigkeit von jQuery oder jQuery Validate.
-->

<style>
.input-container {
    position: relative;
    margin-bottom: 10px;
}

.validationerror {
    color: red;
    font-size: 14px;
    margin-top: 5px;
    display: block;
}

.error {
    border: 1px solid red !important;
}

.valid {
    border: 1px solid green !important;
}
</style>

<script>
    // Initialisierung der Preisberechnung mit reinem JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisiere die Wochenklicks
        weekclick(1);
        weekclick(2);
        weekclick(3);
        weekclick(4);
        weekclick(5);
    });
</script>

</body>
</html>