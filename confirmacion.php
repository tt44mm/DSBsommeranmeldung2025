<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  header('Expires: ' . gmdate("D, d M Y H:i:s", time() + 1000) . ' GMT');
  header('Cache-Control: Private');
  //verhindern, das es neu übermittelt wird
  //header("Location: http://".$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?Check=1", true, 303);
}

include_once("includes/fieldnames_2025.php");
function mystriptag(&$item)
{
  if (!(is_array($item))) {
    $item = strip_tags($item);
  }
}

$usejquery = false;
$usesheepit = false;
$showform = true;



require_once 'includes/headbody_2025.php';
?>

<?php

$kurs_woche0 = array('0');
$kursoptions0 = array('0');

/*
$encryptedpost='p';
$encryptedkurs_woche0='0';
$encryptedkurs_options0='0';
$famhash=hash('crc32b', $_POST['P_DNI']&$_POST['M_DNI']);
if (!(isset($_POST['famIDMulti'])) OR ($_POST['famIDMulti']==""))
 {
    $_POST['famIDMulti']=$famhash;
 }
$encryptedpost=encode_arr($_POST);
if (is_array($kurs_woche0)) $encryptedkurs_woche0=encode_arr($kurs_woche0);
if (is_array($kursoptions0)) $encryptedkurs_options0=encode_arr($kursoptions0);
*/
//zum �bergeben an n�chsten Sch�ler
$encryptedpost = $_POST['encryptedpost'];
$encryptedkurs_woche0 = $_POST['encryptedkurs_woche0'];
$encryptedkurs_options0 = $_POST['encryptedkurs_options0'];
/*
echo "<p>enc: $encryptedpost</p>";
echo "<p>enc: $encryptedkurs_woche0</p>";
echo "<p>enc: $encryptedkurs_options0</p>";
*/
?>
<a id="top" name="top"></a>
<h3>Confirmaci&oacute;n de la inscripci&oacute;n</h3>
<?php
if (sizeof($_POST) > 0 || sizeof($_FILES) > 0) {

  $suma = 0;
  $hijo = '!';
  $arrhijos = array("0", "1", "2", "3", "4");

  if ($_POST['encryptedkurs_woche0'] <> '0') $kurs_woche0 = decode_arr($_POST['encryptedkurs_woche0']);
  if ($_POST['encryptedkurs_options0'] <> '0') $kursoptions0 = decode_arr($_POST['encryptedkurs_options0']);

  $POSTARRAY = decode_arr($_POST['encryptedpost']);

  //echo "<h1>XXXX".$POSTARRAY['op1']."ZZZ</h1>";


  //sicher ist sicher


  array_walk($POSTARRAY, 'mystriptag');

  if (isset($kurs_woche0)) array_walk($kurs_woche0, 'mystriptag');

  /*
	$anzahlWochen= $kurs_woche0[0];
	$weekidx = $kurs_woche0[0]-1;
	*/
  /*<p>CHK_woche: <?php print_r($kurs_woche0[0]);?></p>
    <p>CHK: <?php print_r($kursoptions0[$weekidx]); ?></p>
	*/

  //so klappt es mit den alzten Funktionen
  require_once "includes/addtomysql.php";

  //echo "<p>Eltern: $sqleltern</p>";
  //echo "<p>Kids: $sqlkid</p>";

  //$sendemail its true wenn der Eintrag uniqueID noch nicht in der Datenbank war
  $_POST = $POSTARRAY;

  if ($sendemail) {
    // FAMID aus der addtomysql.php verwenden
    $FAMID = isset($FAMID) ? $FAMID : 100; // Standardwert falls nicht gesetzt
    require_once "includes/sendemail.php";
?>
    <p style="font-size:1.7em;text-align:left;margin-bottom:1em;">&iexcl;Muchas gracias por la inscripci&oacute;n!</p>
    <!--<p><strong>La inscripci&oacute;n se ha realizado con &eacute;xito.</strong>-->
    <p style="font-size:1.2em;text-align:left;margin-bottom:1em;">Recibir&aacute; un Email de confirmaci&oacute;n con el c&oacute;digo<strong>
      <?php echo $bestellnummer . ".</strong></p>";
      $isSavedToDB = true;
    } else { ?>
        <p style="color:red;font-size:1.8em;margin-bottom:1em;"> <strong>La inscripci&oacute;n no ha finalizado con exito<br>
            ERROR: &quot;Por ejemplo: La soliticud est&aacute; ya registrada&quot;. </strong></p>
      <?php
      $isSavedToDB = false;
    }   ?>

      <div id="actions" class="noprint">

        <div style="font-size:1.15em;font-weight:bold;margin:auto;margin:12px;margin-bottom:1.2em;text-align:left;margin-left:0;padding-left:0;background: linear-gradient(170deg , #40C5FA 0%, #20A5FA 15%, #0085CA 100%); padding: 0.4em; color: white;">
          <span>
            &nbsp;Vean abajo los datos y siguientes pasos.&nbsp;&nbsp;
          </span>
        </div>

        <?php
        if (sizeof($_POST) > 0 || sizeof($_FILES) > 0) { ?>
          <form action="anmeldungsommercamp_2025.php" method="post">
            <?php
            /*
   $fld='MfirstName';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='MlastName';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='M_DNI';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='P_DNI';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='PlastName';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='PfirstName';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Phone';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Phone0';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Street';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='PLZ';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Town';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Email1';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Email2';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Busvuelta';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Busvuelta2';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Busida';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='infoKursFundort';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   */
            ?>
            <input type="hidden" value="<?php echo $encryptedpost; ?>" id="encryptedpost" name="encryptedpost" />
            <input type="hidden" value="<?php echo $encryptedkurs_woche0; ?>" id="encryptedkurs_woche0" name="encryptedkurs_woche0" />
            <input type="hidden" value="<?php echo $encryptedkurs_options0; ?>" id="encryptedkurs_options0" name="encryptedkurs_options0" />
            <input type="hidden" value="X" id="2NeuerSchueler" name="NeuerSchueler" />
            <h6>&iquest;Qu&eacute; quieren hacer ahora?</h6>

            <hr />
            <ul class="confirm-actions">
              <li><a href="JavaScript:window.print();">
                  <span class="icon"><i class="far fa-file-alt"></i></span>
                  <span class="icontext">Imprimir confirmaci&oacute;n de inscripci&oacute;n</span>
                </a></li>

              <li><button type="submit" class="submit" name="submit">
                  <span class="icon"><i class="far fa-plus-square"></i></span>
                  <span class="icontext">Realizar otra inscripci&oacute;n </span>
                </button>
                <hr />
              </li>

              <li><a href="https://www.dsbilbao.org/cursos-de-idiomas/campus-de-verano/" target="_parent">
                  <span class="icon"><i class="fas fa-chevron-left"></i></span>
                  <span class="icontext">Volver a la p&aacute;gina del campus de verano 2025</span></a></li>

              <li><a href="https://www.dsbilbao.org/cursos-de-idiomas/" target="_parent">
                  <span class="icon"><i class="fas fa-chevron-circle-left"></i></span>
                  <span class="icontext">Volver a la p&aacute;gina principal de los Cursos de idiomas</span></a></li>

            </ul>
            <hr />


          </form>
      </div>


    <?php
        } ?>

    <h4>Por favor, tengan en cuenta los siguientes pasos indicados en el Email de confirmaci&oacute;n. </h4>

    <?php //2022 Nur showpostdata wenn erfolgreiche Anmeldung
    if ($isSavedToDB) {
    ?>
      <!--<p><strong>La inscripci&oacute;n se ha realizado con &eacute;xito.</strong></p>-->
      <p><strong>Hemos recibido los siguientes datos:</strong></p>
      <?php include("showpostdata.php"); ?>
      <div style="width:95%;margin:auto;padding-top:2em;">
        <p><strong>Han aceptado la siguiente cl&aacute;usula respecto a la protecci&oacute;n de datos personales:</strong>
        <p>
        <h6 align="center"><strong>Cl&aacute;usula respecto a la protecci&oacute;n de datos personales</strong></h6>
        <?php include("clausula.php"); ?>
      </div>
    <?php  } else { ?>
      <p style="color:red;font-size:1.8em"> <strong>Error: La inscripci&oacute;n no ha finalizado con exito!</strong></p>
    <?php }   ?>



    <div id="actions2" class="noprint" style="margin-top:4em!important;">
      <?php
      if (sizeof($_POST) > 0 || sizeof($_FILES) > 0) { ?>
        <form action="anmeldungsommercamp_2025.php" method="post">
          <?php
          /*
   $fld='MfirstName';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='MlastName';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='M_DNI';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='P_DNI';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='PlastName';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='PfirstName';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Phone';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Phone0';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Street';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='PLZ';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Town';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Email1';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Email2';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Busvuelta';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Busvuelta2';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='Busida';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
   $fld='infoKursFundort';$flvalue=$_POST[$fld];echo '<input type="hidden" id="'.$fld.'" name="'.$fld.'" value="'.$flvalue.'">';
	*/
          ?>
          <input type="hidden" value="<?php echo $encryptedpost; ?>" id="Aencryptedpost" name="encryptedpost" />
          <input type="hidden" value="<?php echo $encryptedkurs_woche0; ?>" id="Aencryptedkurs_woche0" name="encryptedkurs_woche0" />
          <input type="hidden" value="<?php echo $encryptedkurs_options0; ?>" id="Aencryptedkurs_options0" name="encryptedkurs_options0" />
          <input type="hidden" value="X" id="1NeuerSchueler" name="NeuerSchueler" />
          <h6>&iquest;Qu&eacute; quiere hacer ahora?</h6>

          <hr />
          <ul class="confirm-actions">
            <li><a href="JavaScript:window.print();">
                <span class="icon"><i class="far fa-file-alt"></i></span>
                <span class="icontext">Imprimir confirmaci&oacute;n de inscripci&oacute;n</span>
              </a></li>

            <li><button type="submit" class="submit" name="submit">
                <span class="icon"><i class="far fa-plus-square"></i></span>
                <span class="icontext">Realizar otra inscripci&oacute;n </span>
              </button>
              <hr />
            </li>

            <li><a href="https://www.dsbilbao.org/cursos-de-idiomas/campus-de-verano/" target="_parent">
                <span class="icon"><i class="fas fa-chevron-left"></i></span>
                <span class="icontext">Volver a la p&aacute;gina del campus de verano 2025</span></a></li>

            <li><a href="https://www.dsbilbao.org/cursos-de-idiomas/" target="_parent">
                <span class="icon"><i class="fas fa-chevron-circle-left"></i></span>
                <span class="icontext">Volver a la p&aacute;gina principal de los Cursos de idiomas</span></a></li>

          </ul>
          <hr />

        </form>

    </div>
  <?php
      } ?>


  </div>





  <!--    Datum der letzten �nderung     -->


  <!--    Datum der letzten �nderung     -->
  <?php require_once 'includes/footer.php'; ?>

  <!--
Thank you page ends here
-->

<?php
  exit();
} else {
  echo "<p>no hay datos</p>";
  require_once 'includes/footer.php';
  exit;
}

if (isset($errors) && sizeof($errors) > 0) {
  foreach ($errors as $error) {
    echo  $error . "<br/>";
  }
}
?></body>

</html>

