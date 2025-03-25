<?php
//<form id="formins1" class="blockStyledForm" method="post" action="">
//    <fieldset>

function sanitize($input) 
{
    if(is_array($input)):
        foreach($input as $key=>$value):
            $result[$key] = sanitize($value);
        endforeach;
    else:
        //$result = htmlentities(strip_tags($input), ENT_QUOTES, 'ISO-8859-1');
		$result = htmlentities(strip_tags($input), ENT_QUOTES, 'UTF-8');
    endif;

    return $result;
}

$POSTsane = sanitize($_POST);

/*	
echo "<pre>"; 
print_r($POSTsane);
echo "</pre><hr>"; 
*/
?>
<div id="showform" style="padding-left: 0;padding-top:5px;">
<div class="legend">Madre o tutor/a 1:</div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float"> Nombre</label> <strong><?php echo strip_tags($POSTsane['MfirstName']) ?></strong></div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float">Apellidos</label> <strong><?php echo strip_tags($POSTsane['MlastName']) ?></strong></div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label class="required float" for="M_DNI">DNI / NIE</label><strong><?php echo strip_tags($POSTsane['M_DNI']) ?></strong></div>

<div class="legend">Padre o tutor/a 2:</div>

        <div class="field" style="padding-left: 10px;padding-top:5px;"><label  class="required float" for="PfirstName">Nombre</label> <strong><?php echo strip_tags($POSTsane['PfirstName']) ?></strong></div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float" for="PlastName">Apellidos</label> <strong><?php echo strip_tags($POSTsane['PlastName']) ?></strong></div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label class="required float" for="M_DNI">DNI / NIE</label><strong><?php echo strip_tags($POSTsane['P_DNI']) ?></strong></div>

<div class="legend">Direcci&oacute;n, contacto:</div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float " for="Street">Direcci&oacute;n (calle y n&uacute;meros)  </label> <strong><?php echo strip_tags($POSTsane['Street']) ?></strong></div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float " for="Town">Poblaci&oacute;n  </label> <strong><?php echo strip_tags($POSTsane['Town']) ?></strong></div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float" for="PLZ">C&oacute;digo Postal  </label> <strong><?php echo strip_tags($POSTsane['PLZ']) ?></strong></div>
        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float" for="Phone">Tel&eacute;fono  </label> <strong><?php echo strip_tags($POSTsane['Phone']) ?></strong></div>

        <?php if (array_key_exists('phone0', $POSTsane) AND (strlen(trim($POSTsane['phone0']))>0) ) {?> <div class="field"  style="padding-left:10px;padding-top:5px;"><label class="notrequired float">Tel&eacute;fono adicional</label><strong>&nbsp;<?php echo strip_tags($POSTsane['phone0']) ?></strong></div><?php } ?>

        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float" for="Email1">Correo electr&oacute;nico  </label> <strong><?php echo strip_tags($POSTsane['Email1']) ?></strong></div>

        <div class="legend">Transporte gratis:</div>

        <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float" for="Busida">Bus ida  </label> <strong><?php echo strip_tags($POSTsane['Busida']) ?></strong></div>

		<div class="field"  style="padding-left:10px;padding-top:5px;">
          <label  class="required float" for="Busvuelta">Bus vuelta </label> <strong><?php echo strip_tags($POSTsane['Busvuelta']) ?></strong></div>

        <div class="field"  style="padding-left:10px;padding-top:5px;">
          <label  class="required float" for="Busvuelta2">Bus vuelta 16:15 </label> <strong><?php echo strip_tags($POSTsane['Busvuelta2']) ?></strong></div>

        <div id="hijos" class="field"  style="padding-left:0;padding-top:5px;">
            <div class="Mainlegend">Alumno/a:</div>


            <?php
			  $sum=0;
              $optionssumme=0;
			  $hijosstrs=array('0','1','2','3','4');

              foreach ($hijosstrs as $hijostr)
			  {

			     $key='nombre'.$hijostr;
                 if (array_key_exists($key, $POSTsane) )
			       {
                       //echo "<hr />"
				  ?>

          <div id="hijo<?php echo $hijostr+1; ?>">
             <!--
             <div class="legend"><strong>Hijo/a <?php //echo $hijostr+1; ?></strong></div>-->

             <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float" for="nombre#index#">Nombre  </label> <strong><?php $key='nombre'.$hijostr; echo strip_tags($POSTsane[$key]) ?></strong></div>

             <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="required float" for="apellidos#index#">Apellidos  </label> <strong><?php $key='apellidos'.$hijostr; echo strip_tags($POSTsane[$key]) ?></strong></div>

             <div class="field"  style="padding-left:10px;padding-top:5px;"><label class="required float"  for="birthdate#index#">Fecha de nacimiento  </label> <strong><?php $key='birthdate'.$hijostr; echo date("d/m/Y", strtotime(strip_tags($POSTsane[$key]))); ?></strong></div>

             <div class="field"  style="padding-left:10px;padding-top:5px;"><br>
                 <label class="required float"  for="colegio#index#">Colegio habitual de la ense&ntilde;anza reglada </label>
				 <strong><?php
				   $key='colegio'.$hijostr;
				   //NEU 2024 $colegio zwischengespeichert wird später für Rabatt gebraucht
				   $colegio = trim(strip_tags($POSTsane[$key]));
				   echo $colegio;

			   ?></strong></div>

               <?php $key='alergias'.$hijostr;
               $content=strip_tags($POSTsane[$key]);
               if (strlen(trim($content))>0) { ?>
            	   <div class="field"  style="padding-left:10px;padding-top:5px;"><label class="notrequired float" for="alergias#index#">Alergias </label><strong>&nbsp;<?php echo "$content</strong></div>";
               }

               $key='intolerancias'.$hijostr;
               $content=strip_tags($POSTsane[$key]);
               if (strlen(trim($content))>0) { ?>
                <div class="field"  style="padding-left:10px;padding-top:5px;"><label class="notrequired float" for="intolerancias#index#">Intolerancias a alimentos </label><strong>&nbsp;<?php echo "$content</strong></div>";
               }

               $key='medicaciones'.$hijostr;
               $content=strip_tags($POSTsane[$key]);
               if (strlen(trim($content))>0) { ?>
                 <div class="field"  style="padding-left:10px;padding-top:5px;"><label class="notrequired float" for="medicaciones#index#">Medicaciones </label><strong>&nbsp;<?php echo "$content</strong></div>";
               }?>

            <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="float required description1">&iquest;Sabe nadar sin ayuda?  </label> <strong><?php $key='nadar'.$hijostr; echo strip_tags($POSTsane[$key]) ?></strong></div>

			<div class="field"  style="padding-left:10px;padding-top:5px;">
              <label class="float required description1">&iquest;Tiene  autorizaci&oacute;n para ba&ntilde;arse en las piscinas hinchables infantiles bajo la  supervisi&oacute;n del profesor/a?    </label> <strong><?php $key='autohinch'.$hijostr; echo strip_tags($POSTsane[$key]) ?></strong></div>

            <div class="field"  style="padding-left:10px;padding-top:5px;"><label class="float required description1">&iquest;Tiene autorizaci&oacute;n para ba&ntilde;arse en la piscina grande bajo la supervisi&oacute;n del socorrista?   </label> <strong><?php $key='autopisci'.$hijostr; echo strip_tags($POSTsane[$key]) ?></strong></div>

             <?php
                  $key='idioma'.$hijostr;
                  $idiomastr = $POSTsane[$key];
            ?>
 		<div class="legend">El  curso al cual se le apunta: <strong>
			<?php
			$cumpleISO=date("Y-m-d", strtotime(strip_tags($POSTsane['birthdate0'])));
            //echo $cumpleISO;
	        $kursName = getKursName($KursNameJung,$KursNameAlt,$cumpleISO, $stichtagkurs); //siehe cursossemanasprecios.php
			echo $kursName;
			?></strong></div>

            <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="float required description1">Idioma  </label> <strong><?php echo strip_tags($POSTsane[$key]);//print_r($POSTsane); ?></strong></div>

      <?php //$currentWeekIdx=0;//diese zeile weg, wenn man die Optionen wochenweise wählen kann
		$showExamen = false;
		/*  
     	if (($kursoptions0[$currentWeekIdx][0]==3) ||
			($kursoptions0[$currentWeekIdx][1]==3) ||
			($kursoptions0[$currentWeekIdx][2]==3) ||
			($kursoptions0[$currentWeekIdx][3]==3) ||
			($kursoptions0[$currentWeekIdx][4]==3)) {
			 $showExamen = true;						?>
			<div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="float description1"></label>
				<span sytle="font-weight:normal">Opci&oacute;n:&nbsp;</span></span><strong>Especial preparatorio para examen oficial para j&oacute;venes y adultos a partir de 13/14 a&ntilde;os.</strong></div>
	 <?php } else 
			$showExamen = false;*/ ?>

            <div class="field"  style="padding-left:10px;padding-top:5px;"><label  class="float required description1" for="obsidioma#index#">Observaciones con respecto al nivel en este idioma  </label> <strong><?php $key='obsidioma'.$hijostr; echo strip_tags($POSTsane[$key]) ?></strong></div>

            <div id="cursos<?php echo $hijostr+1; ?>" style="padding-left:10px;padding-top:5px;">
            <label  class="required description1"> El curso completo del alumno/a </label>
            <table class="table table-striped showtable">
              <thead>
                <tr>
                    <th>Semana</th>
                    <th><center><?php echo $zoption[1]; ?></center></th>
                    <th><center><?php echo $zoption[2]; ?></center></th>
                    <!--<th><?php echo $zoption[3]; ?></th>-->
                    <?php
                       $hkurs_woche=$kurs_woche0;
					   $kursoptions=$kursoptions0;
				    ?>
                </tr>
              </thead>
              <tbody>
				<?php
				$prize=$cursoinscrpcion;
				$oprize[1]=0;
				$oprize[2]=0;
				$oprize[3]=0;
				//echo "<td><strong> $cursovalue[0] </strong></td>\n";
				//echo "<td><strong>".$prize." Euros</strong></td><td>&nbsp;</td><td>&nbsp;</td>";
				//echo "<td>&nbsp;</td>\n";
				//echo "</tr>";
				$wochenanzahl=0;
				$prizeoptions = 0;

							// Initialize destination arrays with six elements, all set to ''
				$weekchecks = array(false, false, false, false, false, false);
				$fruehchecks = array(false, false, false, false, false, false);
				$mittagchecks = array(false, false, false, false, false, false);

				$selectedweeks = array();
				$fruehselectedweeks = array();
				$mittagselectedweeks = array();

				// Loop through source array
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


				$isDSB = ($colegio == "DSB");
				$isEarly = isEarlyBird(); //Early Bird
				
				if ($isDSB) {
					if ($isEarly) {
						$preisindex = 2; //dsbearly
					} else {
						$preisindex = 4; //dsblate
					}								
				} else {
						if ($isEarly) {
							$preisindex = 1; //dsbearly
						} else {
							$preisindex = 3; //dsblate
						}								
				}
/*
							echo "<tr>";
							echo "<td>";							
							print_r($selectedweeks);
							echo " Options ";							
							print_r($kursoptions0);
							echo "</td>";
							echo "<td>Frueh: ";							
					        print_r($fruehselectedweeks);
							echo "</td>";
							echo "<td>Mittag: ";							
					        print_r($mittagselectedweeks);
							echo "</td>";
							echo "</tr>";
*/				
				for ($idx=0; $idx<6; $idx++) {
					if (isset($hkurs_woche[$idx]) && $hkurs_woche[$idx]>'w0') {
						echo "<tr>";
						echo "<td>";
						//print_r($hkurs_woche[$idx]);

						$currentWeekIdx = intval(substr($hkurs_woche[$idx],-1));//entspricht right (letzter Buchstabe von "w4" zum beispiel die 4)
						$wochenanzahl++;
						//Precio jede woche einzeln
						$prize = $prize + $cursoprecio[$currentWeekIdx][$preisindex] + $zusatzpreis;
						if ($fruehchecks[$currentWeekIdx]) $prizeoptions  = $prizeoptions + $fruehcursoprecio[$currentWeekIdx];
						if ($mittagchecks[$currentWeekIdx]) $prizeoptions = $prizeoptions + $mittagcursoprecio[$currentWeekIdx];

						echo "Semana $currentWeekIdx: <span style='font-weight:normal;'>".$week[$currentWeekIdx] . " </span>" . $cursoprecio[$currentWeekIdx][$preisindex] . "&euro;";
						//$currentWeekIdx=0;//diese zeile weg, wenn man die Optionen wochenweise wählen kann
						echo "</td><td><center>";
						if ($fruehchecks[$currentWeekIdx]) echo "<span class='infomobil'>" . $zoption[1] . ": </span><span style='font-weight:normal;'>si</span> " . $fruehcursoprecio[$currentWeekIdx] . "&euro;"; else "no";
						echo "</center></td><td><center>";
						if ($mittagchecks[$currentWeekIdx]) echo "<span class='infomobil'>" . $zoption[2] . ": </span><span style='font-weight:normal;'>si</span> " . $mittagcursoprecio[$currentWeekIdx]  . "&euro;"; else "no";
						echo "</center></td></tr>";
					}
				}

				//das wenn preis je nach Anzahl wochen
			    //$prize = $prize + $cursoprecio[$wochenanzahl];

				//Preisberechnung Discounts 2024
				$preis=1.0 * $prize;

				$discount1active = ($wochenanzahl == 4); //Mehrere Wochen	   
				$discount2active = ($colegio == "DSB"); //DSB schüler
				$discount3active = isEarlyBird(); //Early Bird

				$discountactive[1] = $discount1active;
				$discountactive[2] = $discount2active;
				$discountactive[3] = $discount3active;

				//berechne Preis mit allen Discounts

				//list($newprice, $discountstring,$vollerpreis,$gesamtrabatt) = calculatePricewithDiscounts($preis, $prizeoptions, $discount1percent, $discount2percent, $discount3percent, $discount1active, $discount2active, $discount3active, $discount1name, $discount2name, $discount3name);
				list($newprice, $discountstring, $vollerpreis, $gesamtrabatt)  = calculatePricewithDiscounts($selectedweeks, $fruehselectedweeks, $mittagselectedweeks, $cursoprecio, $fruehcursoprecio, $mittagcursoprecio, $discountactive, $discountnames);

				if ($discount3active) $VorStichtag=1; else $VorStichtag=0;

				$prizetext = $discountstring;

				$prize=$newprice;


				//2022 if (($wochenanzahl==4) AND ($vierwochenpreis > 0))
					 //2022 $prize=$vierwochenpreis; //preisrabatt 980€ statt 1000€ bei Buchung alle 4 Wochen vor Stichtag

				$primerpago = 0;
				$segundopago= $prize-$primerpago;
				if ($segundopago>0)	 {
					$segundopagotext = "Segundo pago: $segundopago Euros hasta el 31 de mayo 2024.";
				} else {
					$segundopagotext = "";
				}

				$gesamthijo=$prize;

		        echo "<tr><td colspan='3' align=\"left\" style='font-size:larger;'>Precio final  <strong>$prizetext</strong></td></tr>";
					 //&nbsp;&nbsp;(Primer pago:&nbsp;260 Euros el d&iacute;a de la inscripci&oacute;n, o unos d&iacute;as antes o despu&eacute;s de la misma. $segundopagotext)</td></tr>";
		  		?>
			</tbody></table>
		</div></div>
						<?php } //if (array_key_exists($key, $POSTsane) )?>

        <?php } //foreach hijosstrs  ?>

</div>
</div>

<div class="legend">C&oacute;mo han conocido nuestra oferta de los campus de verano en  alem&aacute;n, ingl&eacute;s o franc&eacute;s en el Colegio Alem&aacute;n:</div>

  <div class="field" style="padding-left:10px;padding-top:5px;clear:both;border-bottom: solid 1px silver;">
        <span style="padding-left:26px" id="infoKursFundort" name="infoKursFundort"><?php echo strip_tags($POSTsane['infoKursFundort']);?></span>
  </div>
