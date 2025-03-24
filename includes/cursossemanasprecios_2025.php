<?php
/*$tablename_kinder = 'UTF8_V_cursillokinder';
$tablename_familien = 'UTF8_V_cursillofamilien';
$tablename_cfamaccept = 'UTF8_V_cfam_acept';*/

//Umgestellt 2025 alles auf UTF-8
$tablename_cfamaccept = 'cfam_acept';
$tablename_kinder = 'cursillokinder';
$tablename_familien = 'cursillofamilien';

$cursovalue[0] = '';
$cursovalue[1] = ' 1';
$cursovalue[2] = " 2";
$cursovalue[3] = " 3";
$cursovalue[4] = " 4";
$cursovalue[5] = " 5";
$cursovalue[6] = " 6";
$cursovalue[7] = "";
$cursovalue[8] = "";
$cursovalue[9] = "";


$week[1]="30/06 &ndash; 04/07";
$week[2]="07/07 &ndash; 11/07";
$week[3]="14/07 &ndash; 18/07";
$week[4]="21/07 &ndash; 24/07";
$week[5]="";

$fruehoption= "Madrugadores";
$mittagoption= "Comida y actividades por las tardes";
//Preise pro Option und Woche / Einheit
$zoption[1] = $fruehoption;//"Guarder&iacute;a (desde 7:30)";
$zoption[2] = $mittagoption;//"Comedor y tardes (hasta 16:30)";
$zoption[3] = "";
$zoption[4] = "";

$kurseinheiten = "semana";
$kurseinheiten_plural = "semanas";

$cursoinscrpcion = 0;

//EXTERN Early
$cursoprecio[1][1] = 240;
$cursoprecio[2][1] = 240;
$cursoprecio[3][1] = 240;
$cursoprecio[4][1] = 240;
$cursoprecio[5][1] = 0;
$cursoprecio[6][1] = 825; //5Wochenkomplett
//DSB Early
$cursoprecio[1][2] = 190;
$cursoprecio[2][2] = 190;
$cursoprecio[3][2] = 190;
$cursoprecio[4][2] = 190;
$cursoprecio[5][2] = 0;
$cursoprecio[6][2] = 625; //5Wochenkomplett
//EXTERN Late
$cursoprecio[1][3] = 255;
$cursoprecio[2][3] = 255;
$cursoprecio[3][3] = 255;
$cursoprecio[4][3] = 255;
$cursoprecio[5][3] = 0;
$cursoprecio[6][3] = 1020; //5Wochenkomplett
//DSB Late
$cursoprecio[1][4] = 200;
$cursoprecio[2][4] = 200;
$cursoprecio[3][4] = 200;
$cursoprecio[4][4] = 200;
$cursoprecio[5][4] = 0;
$cursoprecio[6][4] = 800; //5Wochenkomplett

$fruehcursoprecio[1] = 45;
$fruehcursoprecio[2] = 45;
$fruehcursoprecio[3] = 45;
$fruehcursoprecio[4] = 45;
$fruehcursoprecio[5] = 0;

$mittagcursoprecio[1] = 85;
$mittagcursoprecio[2] = 85;
$mittagcursoprecio[3] = 85;
$mittagcursoprecio[4] = 85;
$mittagcursoprecio[5] = 0;

$discountnames[1] = "todas las semanas";
$discountpercents[1] = 1;

$discountnames[2] = "alumno/a DSB";
$discountpercents[2] = 1;

$discountnames[3] = "pronto pago";
$discountpercents[3] = 1;


/*
$descricionprecios = '<ul class="multiline2X">
<li>Precio para opcionalmente guarder&iacute;a por la ma&ntilde;ana a partir de las 7:30: <b>40 Euros</b> por semana por alumno/a</li>
<li>Precio para opcionalmente comedor y siesta o actividades a la tarde hasta las 16:30, con servicio de autob&uacute;s: <b>80 Euros</b> por semana por alumno/a</li>';
//<br />
//Precio m&otilde;dulo opcional 3 - guarder&iacute;a por la tarde (14:30-16:30): 25 Euros por semana por alumno/a</p>';
//sommer: $prizes=array(0,250,350,450,550,625);
//$kurseinheiten="semanas";
*/

//2022
$zusatzpreis = 0;
$today =  (mktime(0,0,0)/86400)-18000;//hour, minute, second	 TODAY
//$stichtag = (mktime(0, 0, 0, 6, 1, 2024)/86400)-18000; //1.Juni 2024
//$rabattierterPreis = 980; //alle 4 Wochen vor dem Stichtag Bedingung if //buchungen nach dem Stiochtag kosten extra 10� pro woche
//$vierwochenpreis = 0;
//(($wochenanzahl=4) AND ($vierwochenpreis > 0)) $prize=$vierwochenpreis; //preisrabatt 980� statt 1000� bei Buchung alle 4 Wochen vor Stichtag
//if ($today - $stichtag > 0) $zusatzpreis = 0;
//if ($today - $stichtag <= 0) $vierwochenpreis = $rabattierterPreis;

function isEarlyBird() {
  // Create a new DateTime object with the current date
  $currentDate = new DateTime();

  // Create a new DateTime object for June 1, 2025
  $juneFirst2025 = new DateTime('2025-06-01');

  // Compare the two dates and return true if the current date is before June 1, 2025
  return ($currentDate < $juneFirst2025);
}

function calculatePricewithDiscounts($selectedweeks, $selectedfrueh, $selectedmittag, $cursoprecio, $fruehcursoprecio, $mittagcursoprecio, $discountactive, $discountnames)
{
	$isDSB = $discountactive[2];
	$isEarlyBird = isEarlyBird();


	if ($isEarlyBird) {
		$preisindex = 1; //extern-early
	} else {
		$preisindex = 3; //extern-late
	}

	$orgprice = 0;
	if ($discountactive[1]) { //5Wochen Spezialpreis		
		$orgprice = $cursoprecio[1][$preisindex] +
			$cursoprecio[2][$preisindex] +
			$cursoprecio[3][$preisindex] +
			$cursoprecio[4][$preisindex] +
			$cursoprecio[5][$preisindex];
	} else {
		foreach ($selectedweeks as $curweek)
			$orgprice += $cursoprecio[$curweek][$preisindex];
	}

	/*
	echo "<p> - DSB? $isDSB";
	echo " - EARLY? $isEarlyBird";
	echo " - Orgprice? $orgprice";
	echo " - IDX Preise: $preisindex </p>";
*/
	$prizeoptionen = 0;
	foreach ($selectedfrueh as $curweek)
		$prizeoptionen += $fruehcursoprecio[$curweek];

	foreach ($selectedmittag as $curweek)
		$prizeoptionen += $mittagcursoprecio[$curweek];


	// Calculate the discounts
	//$discount1 = $discount1active ? $discount1percent/100 : 0;
	//$discount2 = $discount2active ? $discount2percent/100 : 0;
	//$discount3 = $discount3active ? $discount3percent/100 : 0;

	// Calculate the new price
	//$newprice = $price * (1 - $discount1) * (1 - $discount2) * (1 - $discount3);

	// Build the discount string

	$descuentos = "";
	$fullprice = $orgprice;
	$prize = $orgprice;
	//mehr als nur eine Woche 5% Rabatt:
	$discounts = [];
	$percent = 0;


	if ($isDSB) {
		if ($isEarlyBird) {
			$preisindex = 2; //dsbearly
		} else {
			$preisindex = 4; //dsblate
		}
		$descuentos = $discountnames[2]; //por DSB
	}

	if (($discountactive[1]) && ($isEarlyBird)) { //5Wochen Spezialpreis
		$prize = $cursoprecio[6][$preisindex];
		if ($descuentos != "") {
			$descuentos = $descuentos . ' + ' . $discountnames[1]; //por 5 semanas
		} else {
			$descuentos = $discountnames[1]; //por 5 semanas
		}
	} else {
		$prize = 0;
		foreach ($selectedweeks as $curweek)
			$prize += $cursoprecio[$curweek][$preisindex];
	}
	/*
	echo "<p> - DSB? $isDSB";
	echo " - EARLY? $isEarlyBird";
	echo " - Prize? $prize";
	echo " - IDX Preise: $preisindex </p>";
*/
	$displayprice = number_format($prize + $prizeoptionen, 2, ',', '');

	if ($fullprice > $prize) {
		$difference = $fullprice - $prize;
		$prizetext = "" . $displayprice . "&euro; (aplicados  " . number_format($difference, 2, ',', '') .  "&euro; de descuento por " . $descuentos . ")";
	} else
		$prizetext = $displayprice . "&euro;";

	//ersetze "." gegen ","
	$prizetext = preg_replace('/\.(\d+)/', ',$1', $prizetext) . '<br /> <a href="https://www.dsbilbao.org/cursos-de-idiomas/campus-de-verano/precios-matriculacion-pagos/" target="_new">Pol&iacute;tica de precios y descuentos</a>';
	$prize = $prize + $prizeoptionen;
	$fullprice = $fullprice  + $prizeoptionen;
	return array($prize, $prizetext, $fullprice, $percent);
}


//f�r Einzelpreise, wie Kurs 1 kostet  1000�, Kurs 2 kostet 1400e ...

//f�r kombinationspreise, wie 1 woche 300�, 2 Wochen 400�, 3Wochen 480� ....
$cursovaluep[1]="1 semana";
$cursovaluep[2]="2 semanas";
$cursovaluep[3]="3 semanas";
$cursovaluep[4]="4 semenas";
$cursovaluep[5]="5 semanas";
$cursovaluep[6]="6 semanas";

//$preciosporhijos=array(0,0,0,0,0);


$stichtagkurs=mktime(0,0,0,1,1,2013); //1 januar 2010 - geburtstag vorher coyote - geburtstag danach Correcaminos
$KursNameJung = " a ";
$KursNameAlt = " b ";


function getKursName(string $KursNameJung, string $KursNameAlt, string $cumpleISO, $stichtagkurs) {
	$geb_tag=1 * substr($cumpleISO,8,2);
	$geb_mon=1 * substr($cumpleISO,5,2);
	$geb_jahr=1 * substr($cumpleISO,0,4);

	//IN cursossemanasprecios.php  $stichtagkurs=mktime(0,0,0,7,5,2009); //F�nfter JUli 2009
	$geburtstag=mktime(0,0,0,$geb_mon,$geb_tag,$geb_jahr);
	
	$alter = getAlter($cumpleISO);

	if ($alter > 12 )
	   $kursName=$KursNameAlt; // (' . $cumpleISO . ' # ' .$alter . ' Jahre alt)';
	else
	   $kursName=$KursNameJung;// (' . $cumpleISO . ' # ' .$alter . ' Jahre alt)';
	return $kursName;
}

function getAlter(string $cumpleISO) {
	$geb_tag=1 * substr($cumpleISO,8,2);
	$geb_mon=1 * substr($cumpleISO,5,2);
	$geb_jahr=1 * substr($cumpleISO,0,4);
	$heute=time();
	$heuteJahr = 1 * date("Y",$heute);
	$geb_ts=mktime(0,0,0,$geb_mon,$geb_tag,$heuteJahr);
	$alter=$heuteJahr-$geb_jahr;
	if ($heute<=$geb_ts) $alter--;
	return $alter;
}

/*
echo "<h1>Show</h1>";

//TEST Der Function
$selectedweeks = array(1, 2,3, 5);
$anzahlwochen = count($selectedweeks);
$selectedfrueh = array(1,3, 4);
$selectedmittag = array(1,3, 4);

$discountactive[2] = true; //is dsb
$discountactive[1] = ($anzahlwochen == 5);



//array($prize, $prizetext, $fullprice, $percent) 
list($newprice, $discountstring, $vollerpreis, $gesamtrabatt)  = calculatePricewithDiscounts($selectedweeks, $selectedfrueh, $selectedmittag, $cursoprecio, $fruehcursoprecio, $mittagcursoprecio, $discountactive, $discountnames);

echo "<ul><li>Newprize = $newprice</li>
<li>DiscountString: $discountstring</li>
<li>Vollerpreis: $vollerpreis</li>
<li>Gesamtrabatt: $gesamtrabatt</li>
</ul>";

?>*/