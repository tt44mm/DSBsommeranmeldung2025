<?php
//echo "start";

require_once ('objects/connect_data.php');

function isMobileDevice() {
return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
$Browser = $_SERVER["HTTP_USER_AGENT"];
if(isMobileDevice()){
  $Browser="Mobile - ".$Browser;
}
else {
  $Browser="Desktop - ".$Browser;
}

function cleanstr($mysqlconnection,$srcstring){
	$dststr = str_replace(['"', "'"], '|', $srcstring);
    $dststr = mysqli_real_escape_string($mysqlconnection,$dststr); 
    return $dststr;                          
}

$tablename = $tablename_cfamaccept; //UTF8 'cfam_acept';

$mysqlconnection = mysqli_connect($server, $user, $pass) or die ("keine Verbindung möglich: " .mysqli_error($mysqlconnection));

//echo "<br>schritt1 ";

if (!$mysqlconnection){echo "<br>Die Verbindung zum MySQL-Server ist fehlgeschlagen!";};
$dbverbindung = @mysqli_select_db($mysqlconnection,$db);
if (!$dbverbindung) {echo "<br>Keine Verbindung zur Datenbank!";} // else {echo "<br>Verbindung zur Datenbank steht!";}
//UTF8
mysqli_query($mysqlconnection, "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");

//erstmal Checken ob nicht der unique key schon existiert
//unique key checken, nur wenn nicht vorhanden neu enmelden und email schicken
//2022 sauber
$uid=cleanstr($mysqlconnection,$_POST['uniqueID']);

//2022 Ersetzt durch parameter Query
//$sqlstr='SELECT * FROM '.$db.".".$tablename. ' WHERE uniqueID="'.$uid.'";';
//$result=mysqli_query($mysqlconnection,$sqlstr) or die(mysqli_error($mysqlconnection));
//$num_rows = mysqli_num_rows($result);
$sqlstr='SELECT * FROM '.$db.".".$tablename. ' WHERE uniqueID=?;';
$stmt=mysqli_stmt_init($mysqlconnection);
if (!mysqli_stmt_prepare($stmt,$sqlstr)) {
	$num_rows=0;
	echo "<p>1: Problem mit dem Datenbankzugriff!</p>";
} else {
	mysqli_stmt_bind_param($stmt,"s",$uid);
	mysqli_stmt_execute($stmt);
	//$num_rows = mysqli_stmt_affected_rows($stmt);
	$num_rows = mysqli_stmt_num_rows($stmt);
	$num_rows = 0;
	//echo "<p>Erfolg - anzahl = $num_rows!</p>";
}

//nur wenn nicht vorhanden!!!! ;
//echo "<br>schritt2 $num_rows";

if ($num_rows < 1)
{
 //2022 gegen cleanstr ersetzt	
 //foreach ($_POST as $pvalue)
 //  $pvalue=str_replace ( '"', "´", $pvalue );

  $FAMID=100;

  $sqlstr='SELECT MAX(FamID) as LastFamID FROM '.$tablename.';';
  //echo $sqlstr;
/*$result=mysqli_query($mysqlconnection,$sqlstr) or die(mysqli_error($mysqlconnection));
  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
*/	
	$stmt=mysqli_stmt_init($mysqlconnection);
	if (!mysqli_stmt_prepare($stmt,$sqlstr)) {
		$num_rows=0;
		echo "<p>2: Problem mit dem Datenbankzugriff!</p>";
	} else {
		//mysqli_stmt_bind_param($stmt,"s",$uid);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$resrow = mysqli_fetch_assoc($result);
		//$num_rows = mysqli_stmt_affected_rows($stmt);
 	    $FAMID=$resrow['LastFamID']+20; //neu FamID 20 groeser als die alte
        //echo "result ".$FAMID." ###";
	}	
	
  //bastle den sqlstring
  /*ab 2022 mit Statement	
  $sqlstr="INSERT INTO ".$db.".".$tablename.
  "   (FamID,nombre_madre,apellidos_madre,nombre_padre,apellidos_padre,calle,codigopostal,poblacion,telefono,telefono1,email,busida,busvuelta,nombre0,fechainscripcion,uniqueID,famIDMulti,Browser) VALUES (".$FAMID.',
"'.cleanstr($mysqlconnection,$_POST['MfirstName']).'",
"'.cleanstr($mysqlconnection,$_POST['MlastName']).'",
"'.cleanstr($mysqlconnection,$_POST['PfirstName']).'",
"'.cleanstr($mysqlconnection,$_POST['PlastName']).'",
"'.cleanstr($mysqlconnection,$_POST['Street']).'",
"'.cleanstr($mysqlconnection,$_POST['PLZ']).'",
"'.cleanstr($mysqlconnection,$_POST['Town']).'",
"'.cleanstr($mysqlconnection,$_POST['Phone']).'",
"'.cleanstr($mysqlconnection,$_POST['phone0']).'",
"'.cleanstr($mysqlconnection,$_POST['Email1']).'",
"'.cleanstr($mysqlconnection,$_POST['Busida']).'",
"'.cleanstr($mysqlconnection,$_POST['Busvuelta']).'",
"'.cleanstr($mysqlconnection,$_POST['nombre0']).'",
NOW(),"'.$uid.'","'.$_POST['famIDMulti'].'","'.$Browser.'");';
  //echo $sqlstr;
  mysqli_query($mysqlconnection,$sqlstr) or die(mysqli_error($mysqlconnection));
  */
  $sqlstr="INSERT INTO ".$db.".".$tablename.
          "   (FamID,nombre_madre,apellidos_madre,nombre_padre,apellidos_padre,calle,codigopostal,poblacion,telefono,telefono1,email,busida,busvuelta,nombre0,uniqueID,famIDMulti,fechainscripcion,Browser) VALUES 
		      (".$FAMID.',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW(),"'.$Browser.'");';
	
	$mvorname=cleanstr($mysqlconnection,$_POST['MfirstName']);
	$mname=cleanstr($mysqlconnection,$_POST['MlastName']);
	$pvorname=cleanstr($mysqlconnection,$_POST['PfirstName']);
	$pname=cleanstr($mysqlconnection,$_POST['PlastName']);
	$street=cleanstr($mysqlconnection,$_POST['Street']);
	$plz=cleanstr($mysqlconnection,$_POST['PLZ']);
	$town=cleanstr($mysqlconnection,$_POST['Town']);
	$tel=cleanstr($mysqlconnection,$_POST['Phone']);
	$tel1=cleanstr($mysqlconnection,$_POST['phone0']);
	$email=cleanstr($mysqlconnection,$_POST['Email1']);
	$busida=cleanstr($mysqlconnection,$_POST['Busida']);
	$vuelta=cleanstr($mysqlconnection,$_POST['Busvuelta']);
	$kidname=cleanstr($mysqlconnection,$_POST['nombre0']);
	$famIDMulti=cleanstr($mysqlconnection,$_POST['famIDMulti']);
	
	$stmt1=mysqli_stmt_init($mysqlconnection);
	if (!mysqli_stmt_prepare($stmt1,$sqlstr)) {
		$num_rows=0;
		echo "<p>3: Problem mit dem Datenbankzugriff!</p>";
	} else {
		//15 strings in abfrage sicher übertragen
		mysqli_stmt_bind_param($stmt1,"sssssssssssssss",
										$mvorname,	
										$mname,
										$pvorname,
										$pname,
										$street,
										$plz,
										$town,
										$tel,
										$tel1,
										$email,
										$busida,
										$vuelta,
										$kidname,
										$uid,					   
										$famIDMulti);
		mysqli_stmt_execute($stmt1);
		$num_rows = mysqli_stmt_affected_rows($stmt1);
		//$num_rows = mysqli_stmt_num_rows($stmt1);
		//echo "<p>Erfolg Insert - anzahl = $num_rows!</p>";
	}

} // numrows > 1 d.h. noch nicht vorhanden


//erstmal Checken ob nicht der unique key schon existiert
//unique key checken, nur wenn nicht vorhanden neu enmelden und email schicken
$uid=$_POST['uniqueID'];
$sqlstr='SELECT * FROM '.$db.".".$tablename. ' WHERE uniqueID="'.$uid.'";';
//echo $sqlstr;
$result=mysqli_query($mysqlconnection,$sqlstr) or die("nicht erfolgreich möglich: " .mysqli_error($mysqlconnection));
$num_rows = mysqli_num_rows($result);

mysqli_close($mysqlconnection);

//nur wenn nicht vorhanden!!!! ;	
