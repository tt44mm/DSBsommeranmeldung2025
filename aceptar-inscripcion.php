<?php
$usejquery = true;
$usesheepit = false;
$showform = true;
require_once 'includes/headbody_2025.php';
include_once("includes/fieldnames_2025.php");
require_once "includes/formvalidator.php";
require_once "includes/cursossemanasprecios_2025.php";
?>
<script type="text/javascript">
// Hilfsfunktion zum Anzeigen der Bootstrap-Fehlermeldung
function showBootstrapError(message) {
  // Prüfen, ob bereits eine Fehlermeldung vorhanden ist
  var existingAlert = document.getElementById('bootstrap-error-alert');
  if (existingAlert) {
    existingAlert.parentNode.removeChild(existingAlert);
  }
  
  // Bootstrap-Alert erstellen
  var alertDiv = document.createElement('div');
  alertDiv.id = 'bootstrap-error-alert';
  alertDiv.className = 'alert alert-danger alert-dismissible fade show';
  alertDiv.role = 'alert';
  alertDiv.style.position = 'fixed';
  alertDiv.style.top = '20px';
  alertDiv.style.left = '50%';
  alertDiv.style.transform = 'translateX(-50%)';
  alertDiv.style.zIndex = '9999';
  alertDiv.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
  alertDiv.style.width = '80%';
  alertDiv.style.maxWidth = '500px';
  
  // Alert-Inhalt
  alertDiv.innerHTML = '\
    <strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ¡Atención!</strong> \
    ' + message + ' \
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> \
      <span aria-hidden="true">&times;</span> \
    </button>';
  
  // Alert zum Body hinzufügen
  document.body.appendChild(alertDiv);
  
  // Alert nach 5 Sekunden automatisch schließen
  setTimeout(function() {
    var alertToRemove = document.getElementById('bootstrap-error-alert');
    if (alertToRemove) {
      alertToRemove.parentNode.removeChild(alertToRemove);
    }
  }, 5000);
  
  // Manuelle Schließen-Funktion hinzufügen
  var closeButton = alertDiv.querySelector('.close');
  if (closeButton) {
    closeButton.addEventListener('click', function() {
      alertDiv.parentNode.removeChild(alertDiv);
    });
  }
}

// Diese Funktion überprüft, ob die Checkbox angekreuzt ist
function validateCheckbox() {
  var agreeCheckbox = document.getElementById('agree');
  var agreeLabel = document.getElementById('labagree');
  var checkboxContainer = agreeCheckbox.parentNode;
  
  if (!agreeCheckbox.checked) {
    // Wenn nicht angekreuzt, zeigen wir die Fehlermeldung deutlich an
    agreeLabel.style.display = 'inline';
    agreeLabel.style.color = 'red';
    agreeLabel.style.fontWeight = 'bold';
    agreeLabel.style.padding = '5px';
    agreeLabel.style.fontSize = '14px';
    
    // Füge eine Hintergrundfarbe zum Fehler hinzu
    checkboxContainer.style.backgroundColor = '#ffeeee';
    
    // Füge einen Rahmen um die Checkbox hinzu
    agreeCheckbox.style.outline = '2px solid red';
    
    // Zum Checkbox-Element scrollen
    agreeCheckbox.scrollIntoView({behavior: 'smooth', block: 'center'});
    
    // Bootstrap-Fehlermeldung anzeigen statt Alert
    showBootstrapError('Por favor, marque la casilla para confirmar que ha leído la cláusula de protección de datos.');
    
    // Submit verhindern
    return false;
  } else {
    // Fehlermeldung ausblenden und Stile zurücksetzen
    agreeLabel.style.display = 'none';
    checkboxContainer.style.backgroundColor = '';
    agreeCheckbox.style.outline = '';
    return true;
  }
}

// Event-Listener hinzufügen, wenn das Dokument geladen ist
document.addEventListener('DOMContentLoaded', function() {
  var agreeCheckbox = document.getElementById('agree');
  var agreeLabel = document.getElementById('labagree');
  var confirmForm = document.getElementById('formins');
  
  // Fehlermeldung initial ausblenden
  agreeLabel.style.display = 'none';
  
  // Bei Änderung der Checkbox Fehlermeldung ein-/ausblenden
  agreeCheckbox.addEventListener('change', function() {
    if (this.checked) {
      // Fehlermeldung ausblenden und Stile zurücksetzen
      agreeLabel.style.display = 'none';
      this.parentNode.style.backgroundColor = '';
      this.style.outline = '';
    }
  });
  
  // Submit-Event abfangen und Validierung durchführen
  confirmForm.addEventListener('submit', function(event) {
    if (!validateCheckbox()) {
      // Prevent form submission if checkbox is not checked
      event.preventDefault();
    }
  });
});
</script>
<h3>Datos de la inscripción</h3>
<?php

if (!(sizeof($_POST) > 0 || sizeof($_FILES) > 0)) {
  echo '<h1 style="color:red;">no hay datos</h1>';
  exit;
} else {
  //sicher ist sicher alles tagging weg

  function mystriptag(&$item)
  {
    $item = strip_tags($item);
  }


  $kurs_woche0 = array('x');
  $kursoptions0 = array('x');
  if (isset($_POST['curso0'])) $kurs_woche0 = $_POST['curso0'];
  if (isset($_POST['zoption0-week'])) $kursoptions0 = $_POST['zoption0-week'];

  /* für multiple Schueler:
    $kurs_woche1=array('x');
    $kursoptions1=array('x');
    if (isset($_POST['curso1'])) $kurs_woche0=$_POST['curso1'];
    if (isset($_POST['zoption1-week'])) $kursoptions0=$_POST['zoption1-week'];


    $kurs_woche2=array('x');
    $kursoptions2=array('x');
    if (isset($_POST['curso2'])) $kurs_woche2=$_POST['curso2'];
    if (isset($_POST['zoption2-week'])) $kursoptions2=$_POST['zoption2-week'];


    $kurs_woche3=array('x');
    $kursoptions3=array('x');
    if (isset($_POST['curso3'])) $kurs_woche3=$_POST['curso3'];
    if (isset($_POST['zoption3-week'])) $kursoptions3=$_POST['zoption3-week'];


    $kurs_woche4=array('x');
    $kursoptions4=array('x');
    if (isset($_POST['curso4'])) $kurs_woche4=$_POST['curso4'];
    if (isset($_POST['zoption4-week'])) $kursoptions4=$_POST['zoption4-week'];


    $kurs_woche5=array('x');
    $kursoptions5=array('x');
    if (isset($_POST['curso5'])) $kurs_woche5=$_POST['curso5'];
    if (isset($_POST['zoption5-week'])) $kursoptions5=$_POST['zoption5-week'];


    $kurs_woche6=array('x');
    $kursoptions6=array('x');
    if (isset($_POST['curso6'])) $kurs_woche6=$_POST['curso6'];
    if (isset($_POST['zoption6-week'])) $kursoptions6=$_POST['zoption6-week'];


    $kurs_woche7=array('x');
    $kursoptions7=array('x');
    if (isset($_POST['curso7'])) $kurs_woche7=$_POST['curso7'];
    if (isset($_POST['zoption7-week'])) $kursoptions7=$_POST['zoption7-week'];
*/


  //Setup Validations
  include_once("setupvalidations.php");

  $encryptedpost = 'p';
  $encryptedkurs_woche0 = '0';
  $encryptedkurs_options0 = '0';

  $famhash = hash('crc32b', $_POST['P_DNI'] & $_POST['M_DNI']);

  //echo "<h1>".$_POST['famIDMulti']."</h1>";//XXXX

  if (!(isset($_POST['famIDMulti'])) or ($_POST['famIDMulti'] == "")) {
    $_POST['famIDMulti'] = $famhash;
  }



  //echo "<h3>".$_POST['famIDMulti']."</h3>";//XX


  $encryptedpost = encode_arr($_POST);
  if (is_array($kurs_woche0)) $encryptedkurs_woche0 = encode_arr($kurs_woche0);
  if (is_array($kursoptions0)) $encryptedkurs_options0 = encode_arr($kursoptions0);
?>

  <?php
  //  echo "<p>CHK_woche: ";

  // Initialize destination arrays with six elements, all set to ''
  $weekchecks = array(false, false, false, false, false, false);
  $fruehchecks = array(false, false, false, false, false, false);
  $mittagchecks = array(false, false, false, false, false, false);

  // Loop through source array
  foreach ($kurs_woche0 as $element) {
    // Extract the type (f or m) and index (numeric part) from the element
    $type = substr($element, 0, 1);
    $index = (int)substr($element, 1);

    // Set the corresponding element in the destination arrays based on the type and index
    if ($type === 'w') {
      $weekchecks[$index] = true;
    }
  }

  // Loop through source array
  foreach ($kursoptions0 as $element) {
    // Extract the type (f or m) and index (numeric part) from the element
    $type = substr($element, 0, 1);
    $index = (int)substr($element, 1);

    // Set the corresponding element in the destination arrays based on the type and index
    if ($type === 'f') {
      $fruehchecks[$index] = true;
    } elseif ($type === 'm') {
      $mittagchecks[$index] = true;
    }
  }

  for ($idx = 0; $idx < 5; $idx++) { //die 5 wochen	
    $idx1 = $idx + 1;
    if (!($cursovalue[$idx1] == "")) {
      //echo "<li>Woche" . $idx1 . ":" .  $weekchecks[$idx1] . " -- Frueh: " . $fruehchecks[$idx1] . " - Mittag: " . $mittagchecks[$idx1] . "</li>"; 
    }
  }
  ?>


  <?php
  require_once 'includes/addtomysqlacept.php';
  //echo "<br>fertig geschrieben ";
  ?>

  <?php
  if (!($validator->ValidateForm())) {
    echo '<h2 style="color:red;">Errores:</h2>';

    $error_hash = $validator->GetErrors();
    foreach ($error_hash as $inpname => $inp_err) {
      echo '<p style="color:red;">' . "$fieldnames[$inpname] ($inpname): $inp_err</p>\n";
    }
  ?>


    <div class="clearl asp">
      <form id="formcorr1" class="blockStyledForm" method="post" action="anmeldungsommercamp_2025.php">
        <fieldset>
          <input type="hidden" value="<?php echo $encryptedpost; ?>" id="Xencryptedpost" name="encryptedpost" />
          <input type="hidden" value="<?php echo $encryptedkurs_woche0; ?>" id="Xencryptedkurs_woche0" name="encryptedkurs_woche0" />
          <input type="hidden" value="<?php echo $encryptedkurs_options0; ?>" id="Xencryptedkurs_options0" name="encryptedkurs_options0" />

          <div id="hinweis">
            <div class="Mainlegend"><strong>Muy importante:</div>
            <p style="margin-top: 1.2em;color:var(--colorHex-dsbBlue);">La inscripción todavía no ha terminado. Para recibir su inscripción necesitamos su <a class="submit" href="#confirm">confirmación</a> </p>
            <p>Si no reciben un correo electrónico con la confirmación, algo falló. <br />
              En tal caso, por favor, intenten enviar la inscripción de nuevo. Muchas gracias.</p>
          </div>
          <div class="field1">
            <p><strong> Por favor, comprueben si los datos son correctos. Al no ser así: </strong>
              <input type="submit" class="btn btn-dsbsecond" name="submit" value=" corregir los datos " />
            </p>
          </div>
        </fieldset>
      </form>

    </div>
  <?php

    include_once("showpostdata.php");
    exit;
  } else {
    //Validation success.
    //Here we can proceed with processing the form
    //(like sending email, saving to Database etc)
    // In this example, we just display a message
    //echo "<p>&nbsp;<!-- validated on server--></p>";
    $show_form = false;

  ?>

    <div class="asp">

      <?php
      $suma = 0;
      $hijo = '!';
      $arrhijos = array("0", "1", "2", "3", "4");

      ?>

      <form id="formcorr2" class="blockStyledForm" method="post" action="anmeldungsommercamp_2025.php">
        <fieldset>

          <input type="hidden" value="<?php echo $encryptedpost; ?>" id="2encryptedpost" name="encryptedpost" />
          <input type="hidden" value="<?php echo $encryptedkurs_woche0; ?>" id="2encryptedkurs_woche0" name="encryptedkurs_woche0" />
          <input type="hidden" value="<?php echo $encryptedkurs_options0; ?>" id="2encryptedkurs_options0" name="encryptedkurs_options0" />


          <div id="hinweis">
            <div class="Mainlegend"><strong>Muy importante:</div>
            <p style="margin-top: 1.2em;color:var(--colorHex-dsbBlue);">La inscripción todavía no ha terminado. Para recibir su inscripción necesitamos su <a class="submit" href="#confirm">confirmación</a> </p>
            <p>Si no reciben un correo electrónico con la confirmación, algo falló. <br />
              En tal caso, por favor, intenten enviar la inscripción de nuevo. Muchas gracias.</p>
          </div>
          <div class="field1">
            <p><strong> Por favor, comprueben si los datos son correctos. Al no ser así: </strong>
              <input type="submit" class="btn btn-dsbsecond" name="submit" value=" corregir los datos " />
            </p>
          </div>
        </fieldset>
      </form>

    </div>

    <?php include_once("showpostdata.php"); ?>

    <div class="clearl asp">
      <form id="formcorr3" class="blockStyledForm" method="post" action="anmeldungsommercamp_2025.php">
        <fieldset>
          <input type="hidden" value="<?php echo $encryptedpost; ?>" id="3encryptedpost" name="encryptedpost" />
          <input type="hidden" value="<?php echo $encryptedkurs_woche0; ?>" id="3encryptedkurs_woche0" name="encryptedkurs_woche0" />
          <input type="hidden" value="<?php echo $encryptedkurs_options0; ?>" id="3encryptedkurs_options0" name="encryptedkurs_options0" />

          <div class="field1">
            <p><strong> Por favor, comprueben si los datos son correctos. Al no ser así: </strong>
              <input type="submit" class="btn btn-dsbsecond" name="submit" value=" corregir los datos " />
            </p>
          </div>
        </fieldset>
      </form>
    </div>

    <div class="clearl asp">
      <p class="clearall">&nbsp;</p>
      <form id="formins" class="form-inline" method="post" action="confirmacion.php">
        <fieldset>
          <div class="Mainlegend">Confirmar:</div>
          <input type="hidden" value="<?php echo $encryptedpost; ?>" id="encryptedpost" name="encryptedpost" />
          <input type="hidden" value="<?php echo $encryptedkurs_woche0; ?>" id="encryptedkurs_woche0" name="encryptedkurs_woche0" />
          <input type="hidden" value="<?php echo $encryptedkurs_options0; ?>" id="encryptedkurs_options0" name="encryptedkurs_options0" />

          <div class="form-row">
            <div class="form-check form-check-inline margins">
              <div class="col-sm-12">
                <strong>He leído la cláusula respecto a la protección de datos personales y estoy de acuerdo.&nbsp;*&nbsp;</strong>&nbsp;<input validate="required:true, minlength:1" id="agree" name="agree" type="checkbox" />&nbsp;<div style="display: inline;color:red">
                  <label id="labagree" for="agree" class="error" style="display:inline">Este campo es obligatorio.</label>
                </div>
              </div>
            </div>
          </div>

          <div class="form-row">
            <p class="text-center col-sm-12" style="color:var(--colorHex-dsbBlue);font-size:larger"><strong><a name="confirm" id="confirm"></a>Pulsen</strong>
              <button type="submit" class="submit btn btn-dsb" name="submit" value="CONFIRMAR" />CONFIRMAR</button>
              <strong>para enviar la inscripción. </strong>
            </p>
          </div>

          <div class="form-row">
            <p>&nbsp;</p>
          </div>

          <blockquote class="klein">
            <h6 align="center"><strong>
                Cláusula respecto a la protección de datos personales</strong></h6>

            <?php include_once("clausula.php"); ?>
          </blockquote>

        </fieldset>
      </form>
      <p class="clearall">&nbsp;</p>
    </div>


    <?php require_once 'includes/footer.php'; ?>

<?php
  }
}
?>