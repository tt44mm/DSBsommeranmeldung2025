<?php  //cursos sommer
require_once ('objects/connect_data.php');

//neu 2022 cleanstrings before instert
function cleanstr($mysqlconnection,$srcstring){
	$dststr = str_replace(['"', "'"], '|', $srcstring);
    $dststr = mysqli_real_escape_string($mysqlconnection,$dststr); 
    return $dststr;                          
}

require_once ('cursossemanasprecios_2025.php');

$tablename= $tablename_familien; //UTF8 'cursillofamilien';
$mysqlconnection = mysqli_connect($server, $user, $pass) or die ("keine Verbindung m&ouml;glich: " .mysqli_error($mysqlconnection));

if (!$mysqlconnection){echo "<br>Die Verbindung zum MySQL-Server ist fehlgeschlagen!";};
$dbverbindung = @mysqli_select_db($mysqlconnection,$db);
if (!$dbverbindung) {echo "<br>Keine Verbindung zur Datenbank!";};
//UTF8
mysqli_query($mysqlconnection, "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");


//erstmal Checken ob nicht der unique key schon existiert
//unique key checken, nur wenn nicht vorhanden neu anmelden und email schicken
$uid=$POSTARRAY['uniqueID'];
$sqlstr='SELECT * FROM '.$db.".".$tablename. ' WHERE uniqueID="'.$uid.'";';
$result=mysqli_query($mysqlconnection,$sqlstr) or die(mysqli_error($mysqlconnection));
$num_rows = mysqli_num_rows($result);


$sendemail = true; //ge�ndert
if ($num_rows>0) $sendemail = false;

if ($sendemail) //ToDo wieder 1
{
	
		    /*if((isset($POSTARRAY['op1'])) &&  ($POSTARRAY['op1']==1))  { $op1 = 1; }  else { $op1 = 0; }
		    if((isset($POSTARRAY['op2'])) &&  ($POSTARRAY['op2']==1))  { $op2 = 1; }  else { $op2 = 0; }
		    if((isset($POSTARRAY['op3'])) &&  ($POSTARRAY['op3']==1))  { $op3 = 1; }  else { $op3 = 0; }
		    if((isset($POSTARRAY['op4'])) &&  ($POSTARRAY['op4']==1))  { $op4 = 1; }  else { $op4 = 0; }
		    if((isset($POSTARRAY['op5'])) &&  ($POSTARRAY['op5']==1))  { $op5 = 1; }  else { $op5 = 0; }
		    if((isset($POSTARRAY['op6'])) &&  ($POSTARRAY['op6']==1))  { $op6 = 1; }  else { $op6 = 0; }
		    if((isset($POSTARRAY['op7'])) &&  ($POSTARRAY['op7']==1))  { $op7 = 1; }  else { $op7 = 0; }
		    if((isset($POSTARRAY['op8'])) &&  ($POSTARRAY['op8']==1))  { $op8 = 1; }  else { $op8 = 0; }
		    if((isset($POSTARRAY['op9'])) &&  ($POSTARRAY['op9']==1))  { $op9 = 1; }  else { $op9 = 0; }
		    if((isset($POSTARRAY['op10'])) && ($POSTARRAY['op10']==1)) { $op10 = 1; } else { $op10= 0; }
		    if((isset($POSTARRAY['op11'])) && ($POSTARRAY['op11']==1)) { $op11 = 1; } else { $op11= 0; }
		    if((isset($POSTARRAY['op12'])) && ($POSTARRAY['op12']==1)) { $op12 = 1; } else { $op12= 0; }
		    if((isset($POSTARRAY['op13'])) && ($POSTARRAY['op13']==1)) { $op13 = 1; } else { $op13= 0; }
		    if((isset($POSTARRAY['op14'])) && ($POSTARRAY['op14']==1)) { $op14 = 1; } else { $op14= 0; }
		    if((isset($POSTARRAY['op15'])) && ($POSTARRAY['op15']==1)) { $op15 = 1; } else { $op15= 0; }
		    if((isset($POSTARRAY['op16'])) && ($POSTARRAY['op16']==1)) { $op16 = 1; } else { $op16= 0; }
		    if((isset($POSTARRAY['op17'])) && ($POSTARRAY['op17']==1)) { $op17 = 1; } else { $op17= 0; }*/
		    if((isset($POSTARRAY['infoKursFundort'])) && ($POSTARRAY['infoKursFundort']=="")) { $infoKursFundort = "n/a"; } else { $infoKursFundort= cleanstr($mysqlconnection, $POSTARRAY['infoKursFundort']); }

//2022 durch cleanstr ersetzt
//foreach ($POSTARRAY as $pvalue)
//  $pvalue=str_replace ( '"', "´", $pvalue );

  $famIDMulti=$POSTARRAY['famIDMulti'];
  $FAMID=100;

  //2022 sicher gemacht	
  $FAMID=100;
  $sqlstr='SELECT MAX(FamID) as LastFamID FROM '.$tablename.';';
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
	
	

  $sqlstr="INSERT INTO ".$db.".".$tablename."(FamID, nombre_madre, apellidos_madre, dni_madre, nombre_padre, apellidos_padre, dni_padre, 
                                              calle, codigopostal, poblacion, telefono, telefono1, email, busida, busvuelta, busvuelta2,  
											  uniqueID,famIDMulti,fechainscripcion) VALUES
   											 (".$FAMID.',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,NOW());';
	
	$mvorname=cleanstr($mysqlconnection,$POSTARRAY['MfirstName']);
	$mname=cleanstr($mysqlconnection,$POSTARRAY['MlastName']);
    $mdni = cleanstr($mysqlconnection, $POSTARRAY['M_DNI']);
	$pvorname=cleanstr($mysqlconnection,$POSTARRAY['PfirstName']);
	$pname=cleanstr($mysqlconnection,$POSTARRAY['PlastName']);
    $pdni=cleanstr($mysqlconnection, $POSTARRAY['P_DNI']);
	$street=cleanstr($mysqlconnection,$POSTARRAY['Street']);
	$plz=cleanstr($mysqlconnection,$POSTARRAY['PLZ']);
	$town=cleanstr($mysqlconnection,$POSTARRAY['Town']);
	$tel=cleanstr($mysqlconnection,$POSTARRAY['Phone']);
	$tel1=cleanstr($mysqlconnection,$POSTARRAY['phone0']);
	$email=cleanstr($mysqlconnection,$POSTARRAY['Email1']);
	$busida=cleanstr($mysqlconnection,$POSTARRAY['Busida']);
	$vuelta=cleanstr($mysqlconnection,$POSTARRAY['Busvuelta']);
    $vuelta2=cleanstr($mysqlconnection, $POSTARRAY['Busvuelta2']);
	$uid=cleanstr($mysqlconnection,$POSTARRAY['uniqueID']);
	$famIDMulti=cleanstr($mysqlconnection,$POSTARRAY['famIDMulti']);
	
	$stmt1=mysqli_stmt_init($mysqlconnection);
	if (!mysqli_stmt_prepare($stmt1,$sqlstr)) {
		$num_rows=0;
		echo "<p>3: Problem mit dem Datenbankzugriff!</p>";
		$sendemail=false;
	} else {
		//15 strings in abfrage sicher �bertragen
		mysqli_stmt_bind_param($stmt1,"sssssssssssssssss",
										$mvorname,	
										$mname,
							   			$mdni,
										$pvorname,
										$pname,
							   			$pdni,
										$street,
										$plz,
										$town,
										$tel,
										$tel1,
										$email,
										$busida,
										$vuelta,
							   			$vuelta2,
										$uid,					   
										$famIDMulti);
		mysqli_stmt_execute($stmt1);
		$num_rows = mysqli_stmt_affected_rows($stmt1);
		//$num_rows = mysqli_stmt_num_rows($stmt1);
		//echo "<p>Erfolg Insert - anzahl = $num_rows!</p>";
	}
  //new 2022-04 check ob insert erfolgreich
	if ($num_rows < 1) {
		$sendemail=false;
		$emailSubject = "DSB SOMMER Add Eltern FAILED SQL Statement";
		$emailBody = "The following SQL statement failed:\n\n" . $sqlstr;
		$emailBody .= " \n\n Parameters:\n\n
		
                        mvorname: $mvorname |||,	
						mname: $mname |||,
						mdni: $mdni |||,
						pvorname: $pvorname |||,
						pname: $pname |||,
						pdni: $pdni |||,
						street: $street |||,
						plz: $plz |||,
						town: $town |||,
						tel: $tel |||,
						tel1: $tel1 |||,
						email: $email |||,
						busida: $busida |||,
						vuelta: $vuelta |||,
						vuelta2: $vuelta2 |||,
						uid: $uid |||,								   
						famidMulti: $famIDMulti |||
						";	
		$emailBody .= "\n\n SQL resulting with Parameters included: \n\n		
                       INSERT INTO ".$db.".".$tablename."(FamID, nombre_madre, apellidos_madre, dni_madre, nombre_padre, apellidos_padre, dni_padre, 
                                              calle, codigopostal, poblacion, telefono, telefono1, email, busida, busvuelta, busvuelta2,  
											  uniqueID,famIDMulti,fechainscripcion) VALUES
   											 (".$FAMID.",'$mvorname','$mname','$mdni','$pvorname','$pname','$pdni','$street','$plz','$town','$tel','$tel1','$email','$busida','$vuelta','$vuelta2','$uid','$famIDMulti',NOW());";		
		$emailHeaders = "From: info@lightroom-tutorial.de";
		mail("tm@sts.support", $emailSubject, $emailBody, $emailHeaders);
	}
  // end new

	$tablename = $tablename_kinder; //UTF8 'cursillokinder';

  $nr='0';
  $nrrs=array('0','1','2','3','4');
  $wvalues=$cursovalue; //aus dem include cursossemanasprecios

  //foreach ($nrrs as $nr)//nur noch ein Kind '0'
  {
   
   $key='nombre'.$nr;

   if (array_key_exists($key, $POSTARRAY) )
	 {
            $hkurs_woche=$kurs_woche0;
	        $kursoptions=$kursoptions0; 
	   
			//welche Wochen und Optionen
	   		//Init	   		
	   		$IsChecked=array();
	        $IsChecked[] = array(0,1,2,3,4,5,6);//zweidimensional
	   
			// Initialize destination arrays with six elements, all set to ''
			$weekchecks = array(false, false, false, false, false, false);
			$fruehchecks = array(false, false, false, false, false, false);
			$mittagchecks = array(false, false, false, false, false, false);

			// Loop through source array

			$selectedweeks = array();
			$fruehselectedweeks = array();
			$mittagselectedweeks = array();
			foreach ($kurs_woche0 as $element) {
				// Extract the type (f or m) and index (numeric part) from the element
				$type = substr($element, 0, 1);
				$index = (int)substr($element, 1);

				// Set the corresponding element in the destination arrays based on the type and index
				if ($type === 'w') {
					$weekchecks[$index] = true;
					$selectedweeks[] = $index;
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
					$fruehselectedweeks[] = $index;
				} elseif ($type === 'm') {
					$mittagchecks[$index] = true;
					$mittagselectedweeks[] = $index;
				}
			}
		   
//----------------------------------------------------------------
	        //initialisieren
			for ($idx=1; $idx<7; $idx++) {
					$IsChecked[$idx][1]=0;
					$IsChecked[$idx][2]=0; //Guaderia
					$IsChecked[$idx][3]=0; //Comedor / Tardes
					$IsChecked[$idx][4]=0; //unbenutzt
			}
	   
	        //welche Wochen und Optionen sind gecheckt
	        $wochenanzahl=0;
	        $prizeoptions=0;
			$prize = 0; // Initialisiere die Variable $prize
			for ($idx=0; $idx<6; $idx++) {
				if (isset($hkurs_woche[$idx]) && $hkurs_woche[$idx]>'w0') {
					$currentWeekIdx = intval(substr($hkurs_woche[$idx],-1));//entspricht right (letzter Buchstabe von "w4" zum beispiel die 4)											
					$wochenanzahl++;
					//Precio jede woche einzeln
					//$prize = $prize + $cursoprecio[$currentWeekIdx][1]} + $zusatzpreis;
					$IsChecked[$currentWeekIdx][1]=1;					
				    if ($fruehchecks[$currentWeekIdx]) {
						//$prizeoptions  = $prizeoptions + $fruehcursoprecio[$currentWeekIdx];
						$IsChecked[$currentWeekIdx][2]=1; //Guaderia
					}					
					if ($mittagchecks[$currentWeekIdx]) {
						//$prizeoptions = $prizeoptions + $mittagcursoprecio[$currentWeekIdx];						
						$IsChecked[$currentWeekIdx][3]=1; //Comedor / Tardes
					}															
				}											
			} 	   	   	   	   	   	   
   			$colegio=cleanstr($mysqlconnection, trim($POSTARRAY['colegio'.$nr]));	   
            $preis=1.0 * $prize;	   
//----------------------------------------------------------------
	        $discount1active=($wochenanzahl==4);//Mehrere Wochen	   
	        $discount2active=($colegio=="DSB");//DSB sch�ler
	        $discount3active=isEarlyBird(); //Early Bird

			$discountactive[1] = $discount1active;
			$discountactive[2] = $discount2active;
			$discountactive[3] = $discount3active;



            //berechne Preis mit allen Discounts
	   	  
	   		//list($newprice, $discountstring,$vollerpreis,$gesamtrabatt) = calculatePricewithDiscounts($preis, $prizeoptions, $discount1percent, $discount2percent, $discount3percent, $discount1active, $discount2active, $discount3active, $discount1name, $discount2name, $discount3name);
			list($newprice, $discountstring, $vollerpreis, $gesamtrabatt)  = calculatePricewithDiscounts($selectedweeks, $fruehselectedweeks, $mittagselectedweeks, $cursoprecio, $fruehcursoprecio, $mittagcursoprecio, $discountactive, $discountnames);
	   	   
	        //write integers to Datenbank
	        if ($discount3active) $VorStichtag='1'; else $VorStichtag='0';	   	        
            if ($discount1active) $discount1active='1'; else $discount1active='0';	   
	        if ($discount2active) $discount2active='1'; else $discount2active='0';	   
	        if ($discount3active) $discount3active='1'; else $discount3active='0';	   
	   
	        //alles mit real escape
			$nombre=cleanstr($mysqlconnection, $POSTARRAY['nombre'.$nr]);
			$apellidos=cleanstr($mysqlconnection, $POSTARRAY['apellidos'.$nr]);
			$cumple=cleanstr($mysqlconnection, $POSTARRAY['birthdate'.$nr]);

			//test split bei .
			//test split by /
			/*$teil = explode("/", $cumple);			
			if (strlen(trim($teil[0]))<2) $teil[0]="0".trim($teil[0]);
			if (strlen(trim($teil[1]))<2) $teil[1]="0".trim($teil[1]);
			if (strlen(trim($teil[2]))==2) $teil[2]="20".trim($teil[2]);
			$cumpleISO=trim($teil[2]) . "-" . trim($teil[1]) . "-" . trim($teil[0]);*/
	        //neu20-21 
	        $cumpleISO=$cumple;
	        $kursName = getKursName($KursNameJung,$KursNameAlt,$cumpleISO, $stichtagkurs); //siehe cursossemanasprecios.php 					 
	   
			//$cumpleISO=substr($cumple,6,4) . "-" . substr($cumple,3,2) . "-" . substr($cumple,0,2);

			$alergias=cleanstr($mysqlconnection, $POSTARRAY['alergias'.$nr]);
			$intolerancias=cleanstr($mysqlconnection, $POSTARRAY['intolerancias'.$nr]);
			$medicaciones=cleanstr($mysqlconnection, $POSTARRAY['medicaciones'.$nr]);
			if ($POSTARRAY['nadar'.$nr]=="Si") $nadar=1; else $nadar=0;
			if ($POSTARRAY['autopisci'.$nr]=="Si") $auto_piscina=1; else $auto_piscina=0;
			if ($POSTARRAY['autohinch'.$nr]=="Si") $auto_hinchable=1; else $auto_hinchable=0;
			if ($POSTARRAY['dsb'.$nr]=="Si") $dsb=1; else $dsb=0;
			$idioma_curso=$POSTARRAY['idioma'.$nr]; //achtung umlaute / akzente

			if ($idioma_curso[0] == 'I') {
				$idioma_curso = "Inglés";
			} elseif ($idioma_curso[0] == 'A') {
				$idioma_curso = "Alemán";
			} elseif ($idioma_curso[0] == 'F') {
				$idioma_curso = "Francés";
			}
			if ($POSTARRAY['autopisci'.$nr]=="Si") $auto_piscina=1; else $auto_piscina=0;
			//$idioma_curso = mb_convert_encoding($idioma_curso, "ISO-8859-1", "UTF-8");
// Write the value to the database


			$observaciones_idioma=cleanstr($mysqlconnection, $POSTARRAY['obsidioma'.$nr]);

			$busida=cleanstr($mysqlconnection, $POSTARRAY['Busida']);
			$busvuelta=cleanstr($mysqlconnection, $POSTARRAY['Busvuelta']);
			$busvuelta2=cleanstr($mysqlconnection, $POSTARRAY['Busvuelta2']);

			//neu2024 mit discounts 1 bis 43 und preistxt

			//$discount3active = '0'; //
	        $sqlstr="INSERT INTO ".$db.".".$tablename.
			" (FamID,nombre,apellidos,cumple,colegio,alergias,intolerancias,medicaciones,
			nadar,auto_piscina,auto_hinchable,idioma_curso,observaciones_idioma,dsb,
			semana1,semana1o1,semana1o2,semana1o3,semana2,semana2o1,semana2o2,semana2o3,
			semana3,semana3o1,semana3o2,semana3o3,semana4,semana4o1,semana4o2,semana4o3,
			semana5,semana5o1,semana5o2,semana5o3,semana6,semana6o1,semana6o2,semana6o3,
			busida,busvuelta,busvuelta2,infoKursFundort,kidfamIDMulti,
			Preis,pricetxtemail,VorStichtag,KursName,discount1active,discount2active,discount3active,".
			"VollerPreis,
			GesamtRabatt,".	
			//"op1,op2,op3,op4,op5,op6,op7,op8,op9,op10,op11,op12,op13,op14,op15,op16,op17,".
			"fechainscription) VALUES (".
			$FAMID.',?,?,?,?,?,?,?,'.
			$nadar.','.$auto_piscina.','.$auto_hinchable.',?,?,'.$dsb.','.				
			$IsChecked[1][1].','.$IsChecked[1][2].','.$IsChecked[1][3].','.$IsChecked[1][4].','.	
			$IsChecked[2][1].','.$IsChecked[2][2].','.$IsChecked[2][3].','.$IsChecked[2][4].','.	
			$IsChecked[3][1].','.$IsChecked[3][2].','.$IsChecked[3][3].','.$IsChecked[3][4].','.	
			$IsChecked[4][1].','.$IsChecked[4][2].','.$IsChecked[4][3].','.$IsChecked[4][4].','.	
			$IsChecked[5][1].','.$IsChecked[5][2].','.$IsChecked[5][3].','.$IsChecked[5][4].','.	
			$IsChecked[6][1].','.$IsChecked[6][2].','.$IsChecked[6][3].','.$IsChecked[6][4].','.	
			'?,?,?,?,?,'.
			$newprice.',?,'.$VorStichtag.',?,'.$discount1active.','.$discount2active.','.$discount3active.','.	
			$vollerpreis . ',' . $gesamtrabatt . ',' .	
			//$op1.','.$op2.','.$op3.','.$op4.','.$op5.','.$op6.','.$op7.','.$op8.','.$op9.','.$op10.','.$op11.','.$op12.','.$op13.','.$op14.','.$op15.','.$op16.','.$op17.','.
			'NOW());';
			   
			$stmt2=mysqli_stmt_init($mysqlconnection);
			if (!mysqli_stmt_prepare($stmt2,$sqlstr)) { //KIND und kurswahl speichern
				$num_rows=0;
				echo "<p>4: Problem mit dem Datenbankzugriff! $sqlstr</p>";
				$sendemail=false;
			} else {
				//15 strings in abfrage sicher �bertragen
				mysqli_stmt_bind_param($stmt2,"ssssssssssssssss",
											   $nombre,
											   $apellidos,
											   $cumpleISO,
											   $colegio,
											   $alergias,
											   $intolerancias,
											   $medicaciones,
											   $idioma_curso,
											   $observaciones_idioma,
											   $busida,
											   $busvuelta,
											   $busvuelta2,
											   $infoKursFundort,
											   $famIDMulti,
									           $discountstring,
									           $kursName);
				mysqli_stmt_execute($stmt2);
				$num_rows2 = mysqli_stmt_affected_rows($stmt2);
				//$num_rows = mysqli_stmt_num_rows($stmt1);
				//echo "<p>Erfolg Insert - anzahl = $num_rows!</p>";
			}	   
	     if ($num_rows2<1) $sendemail=false;	             
	if ($num_rows2 < 1) {
		$sendemail=false;
		$emailSubject = "DSB SOMMER Add Kind Failed SQL Statement";
		$emailBody = "The following SQL statement has failed:\n\n" . $sqlstr;
		$emailBody .= "\n\n Parameters:
		nombre: $nombre |||,
		apellidos: $apellidos |||,
		cumpleISO: $cumpleISO |||,
		colegio: $colegio |||,
		alergias: $alergias |||,
		inteolerancias: $intolerancias |||,
		medicaciones: $medicaciones |||,
		idioma_curso: $idioma_curso |||,
		observaciones_idioma: $observaciones_idioma |||,
		busida: $busida |||,
		busvuelta: $busvuelta |||,
		busvuelta2: $busvuelta2 |||,
		infoKursFundort: $infoKursFundort |||,
		famIDMulti: $famIDMulti |||,
		discountstring: $discountstring |||,
	    kursName: $kursName |||
		";
		$emailBody .= "\n\n SQL resulting with Parameters included: \n\n
		
        INSERT INTO ".$db.".".$tablename.
			" (FamID,nombre,apellidos,cumple,colegio,alergias,intolerancias,medicaciones,
			nadar,auto_piscina,auto_hinchable,idioma_curso,observaciones_idioma,dsb,
			semana1,semana1o1,semana1o2,semana1o3,semana2,semana2o1,semana2o2,semana2o3,
			semana3,semana3o1,semana3o2,semana3o3,semana4,semana4o1,semana4o2,semana4o3,
			semana5,semana5o1,semana5o2,semana5o3,semana6,semana6o1,semana6o2,semana6o3,
			busida,busvuelta,busvuelta2,infoKursFundort,kidfamIDMulti,
			Preis,pricetxtemail,VorStichtag,KursName,discount1active,discount2active,discount3active,".
			"VollerPreis,
			GesamtRabatt,".	
			//"op1,op2,op3,op4,op5,op6,op7,op8,op9,op10,op11,op12,op13,op14,op15,op16,op17,".
			"fechainscription) VALUES (".
			$FAMID.",'$nombre','$apellidos','$cumpleISO','$colegio','$alergias','$intolerancias','$medicaciones',".
			$nadar.','.$auto_piscina.','.$auto_hinchable.",'$idioma_curso','$observaciones_idioma',".$dsb.','.				
			$IsChecked[1][1].','.$IsChecked[1][2].','.$IsChecked[1][3].','.$IsChecked[1][4].','.	
			$IsChecked[2][1].','.$IsChecked[2][2].','.$IsChecked[2][3].','.$IsChecked[2][4].','.	
			$IsChecked[3][1].','.$IsChecked[3][2].','.$IsChecked[3][3].','.$IsChecked[3][4].','.	
			$IsChecked[4][1].','.$IsChecked[4][2].','.$IsChecked[4][3].','.$IsChecked[4][4].','.	
			$IsChecked[5][1].','.$IsChecked[5][2].','.$IsChecked[5][3].','.$IsChecked[5][4].','.	
			$IsChecked[6][1].','.$IsChecked[6][2].','.$IsChecked[6][3].','.$IsChecked[6][4].','.	
			"'$busida','$busvuelta','$busvuelta2','$infoKursFundort','$famIDMulti',".
			$newprice.",'$discountstring',".$VorStichtag.",'$kursName',".$discount1active.','.$discount2active.','.$discount3active.','.	
			$vollerpreis . ',' . $gesamtrabatt . ',' . 'NOW());';		
		$emailHeaders = "From: info@lightroom-tutorial.de";
		mail("tm@sts.support", $emailSubject, $emailBody, $emailHeaders);
	}
	    	   
	     // end new
	 }
  }
if ($sendemail) $sqlstr='UPDATE cfam_acept SET confirmed=1 WHERE uniqueID="'.$uid.'"';
}
/*
mysql_query($sqlstr,$mysqlconnection);
mysql_close($mysqlconnection) ;
*/
mysqli_query($mysqlconnection,$sqlstr); //KIND und kurswahl speichern
	        //echo $sqlstr;	        
			//new 2020-04 check ob insert erfolgreich
	        /*
	   		  $sqlkid = $sqlstr;
			  if (mysqli_query($mysqlconnection,$sqlstr)) {
				  if (mysqli_affected_rows($mysqlconnection) < 1) $sendemail=false;
			  } else {
				  $sendemail=false; //Kein erfolg
			  }
	         */
	   



mysqli_close($mysqlconnection) ;
