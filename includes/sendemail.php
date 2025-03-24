<?php
//include_once("wff_misc.php");
//include_once("objects/class.phpmailer.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'objects/src/Exception.php';
require 'objects/src/PHPMailer.php';
require 'objects/src/SMTP.php';


function htmlentitiesOutsideHTMLTags ($htmlText)
{
    $matches = Array();
    $sep = '###HTMLTAG###';

    preg_match_all("@<[^>]*>@", $htmlText, $matches);
    $tmp = preg_replace("@(<[^>]*>)@", $sep, $htmlText);
	$tmp = explode($sep, $tmp);

    for ($i=0; $i<count($tmp); $i++)
        $tmp[$i] = htmlentities($tmp[$i]);

    $tmp = join($sep, $tmp);

    for ($i=0; $i<count($matches[0]); $i++)
        $tmp = preg_replace("@$sep@", $matches[0][$i], $tmp, 1);

    return $tmp;
}

$address = $POSTARRAY['Email1'];

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';


$mail->From = 't.menath@dsbilbao.org';
$mail->FromName = 'Thomas Menath';
$mail->AddAddress($address);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = "inscripcion@dsbilbao.org";  // GMAIL username
$mail->Password   = "rkmurrahqgmkysnb";       // "2factor wintersommer";            // GMAIL password

$dsb = 'Colegio Alemán de Bilbao';//mb_convert_encoding('Colegio Alemán de Bilbao', "ISO-8859-1", "UTF-8");
$sendsubject = 'Campus de verano 2025 en alemán, inglés o francés - Confirmación: '; //mb_convert_encoding('Campus de verano 2024 en alemán, inglés o francés - Confirmación: ', "ISO-8859-1", "UTF-8");

$mail->SetFrom('inscripcion@dsbilbao.org', $dsb);
$mail->AddReplyTo("inscripcion@dsbilbao.org",$dsb);
$mail->addAttachment('DSB_clausula_proteccion_de_datos_para_firmar.pdf');//neu 2022

// Stelle sicher, dass FAMID definiert ist
if (!isset($FAMID)) {
    $FAMID = isset($POSTARRAY['FamID']) ? $POSTARRAY['FamID'] : '1000';
}

$bestellnummer=substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVW", 2)), 0, 2);
$bestellnummer=$bestellnummer.$FAMID.substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVW", 2)), 0, 2);
//ZufallsZiffernBuchstaben in de rmite die FamilyID

$mail->Subject    = $sendsubject . $bestellnummer;// - inscripci&oacute;n ".$nummer
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$message = "<p> </p>";
$errors = array();

ob_start();//ausgaben in Variable umleiten
include("confirmacion_email.php");
include("showpostdataEmail.php");
$message .= ob_get_contents();
ob_end_clean();

// Jetzt setzen wir den Body
$body = $message;
$mail->MsgHTML($body);

//$mail->AddAttachment($value['tmp_name'], $value['name'], "base64", $value['type']);
//$message .= "------ end of message ------";
if (sizeof($errors) == 0)
{
	//$mail->Body = htmlentitiesOutsideHTMLTags($message);//nicht mehr notwendig da schon in shopostdata erledigt
	$mail->Body = $message;
	$mail->Send();
}

