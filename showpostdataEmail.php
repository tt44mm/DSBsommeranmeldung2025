<?php
function sanitizeEmailPOST($input)
{
  if (is_array($input)) :
    foreach ($input as $key => $value) :
      $result[$key] = sanitizeEmailPOST($value);
    endforeach;
  else :
    //$result = htmlentities(strip_tags($input), ENT_QUOTES, 'ISO-8859-1');
    $result = htmlentities(strip_tags($input), ENT_QUOTES, 'UTF-8');
  endif;

  return $result;
}

$POSTsaneEmail = sanitizeEmailPost($_POST);


//<form id="formins1" class="blockStyledForm" method="post" action="">
//    <fieldset>
$stylelegend = ' style="padding:0.25em;font-weight: bold; font-size: 1em; margin-top: 3px; margin-right: 0; margin-bottom: 5px; margin-left: 0; padding-top: 2px; padding-right: 0; padding-bottom: 2px; padding-left: 1em; background-color: #0085CA;color:white;"';
$stylemargin =     ' style=""';
$stylelabmargin =  ' style="padding:0.25em;margin-left: 0px; margin-bottom: 1px; margin-top: 8px; margin-right: 0px;"';
$stylelabrequired = ' style="display: inline; font-weight: bold; color: #0085CA; margin-top: 0; margin-right: 10px; margin-bottom: 0;"';
$stylelabel = ' style="padding:0.25em;display: inline; margin-top: 0; margin-right: 10px; margin-bottom: 0;"';
$stylemainlegend = ' style="padding:0.25em;font-weight: bold; font-size: 1.2em; margin-top: 3px; margin-right: 0; margin-bottom: 5px; margin-left: 0; padding-top: 2px; padding-right: 0; padding-bottom: 2px; padding-left: 1em; background-color: #0085CA;color:white;"';
$stylekidlabrequired = ' style="padding:0.25em;display: inline; font-weight: bold; color: #0085CA; margin-top: 0; margin-right: 10px; margin-bottom: 0;"';
$stylekidlabrequired = ' style="margin-top:035em;padding:0.15em;display: inline; font-weight: bold; color: #0085CA; margin-right: 5px; margin-bottom: 0;"';


?>
<div <?php echo $stylelegend; ?>>Madre o tutor/a 1:</div>
<div <?php echo $stylemargin; ?>>
  <span <?php echo $stylelabrequired; ?>> Nombre</span>
  <strong><?php echo strip_tags($POSTsaneEmail['MfirstName']) ?></strong>
</div>
<div>
  <span <?php echo $stylelabrequired; ?>>Apellidos</span>
  <strong><?php echo strip_tags($POSTsaneEmail['MlastName']) ?></strong>
</div>
<div>
  <span <?php echo $stylelabrequired; ?>>DNI/NIE</span>
  <strong><?php echo strip_tags($POSTsaneEmail['M_DNI']) ?></strong>
</div>


<div <?php echo $stylelegend ?>>Padre o tutor/a 2:</div>
<div <?php echo $stylemargin; ?>>
  <span <?php echo $stylelabrequired; ?>>Nombre</span>
  <strong><?php echo strip_tags($POSTsaneEmail['PfirstName']) ?></strong>
</div>
<div>
  <span <?php echo $stylelabrequired; ?>>Apellidos</span>
  <strong><?php echo strip_tags($POSTsaneEmail['PlastName']) ?></strong>
</div>
<div>
  <span <?php echo $stylelabrequired; ?>>DNI/NIE</span>
  <strong><?php echo strip_tags($POSTsaneEmail['P_DNI']) ?></strong>
</div>


<div <?php echo $stylelegend ?>>Direcci&oacute;n, contacto:</div>
<div <?php echo $stylemargin; ?>>
  <span <?php echo $stylelabrequired; ?>>Direcci&oacute;n </span>
  <strong><?php echo strip_tags($POSTsaneEmail['Street']) ?></strong>
</div>
<div>
  <span <?php echo $stylelabrequired; ?>>Poblaci&oacute;n </span>
  <strong><?php echo strip_tags($POSTsaneEmail['Town']) ?></strong>
</div>
<div>
  <span <?php echo $stylelabrequired; ?>>C&oacute;digo Postal </span>
  <strong><?php echo strip_tags($POSTsaneEmail['PLZ']) ?></strong>
</div>
<div>
  <span <?php echo $stylelabrequired; ?>>Tel&eacute;fono </span>
  <strong><?php echo strip_tags($POSTsaneEmail['Phone']) ?></strong>
</div>
<?php if (array_key_exists('phone0', $POSTsaneEmail) and (strlen(trim($POSTsaneEmail['phone0'])) > 0)) { ?>
  <div>
    <span <?php echo $stylelabrequired; ?>>Tel&eacute;fono adicional</span>
    <strong>&nbsp;<?php echo strip_tags($POSTsaneEmail['phone0']) ?><strong>
  </div>
<?php } ?>

<div <?php echo $stylelabmargin; ?>>
  <span <?php echo $stylelabrequired; ?>> Correo electr&oacute;nico </span>
  <strong> <?php echo strip_tags($POSTsaneEmail['Email1']) ?> </strong>
</div>


<div <?php echo $stylelegend ?>>Transporte gratis:</div>
<div style="font-weight: normal; font-size: .9em;margin-left: 0px; margin-bottom: 1px; margin-top: 3px; margin-right: 0px; overflow: hidden; _height: 0.1%;"> Se puede utilizar distintas l&iacute;neas de autob&uacute;s y distintas paradas de autob&uacute;s en ida y vuelta. Est&aacute;n garantizadas las paradas elegidas en la inscripci&oacute;n, siempre que haya un n&uacute;mero suficiente de alumnos para crear un recorrido que incluye estas paradas elegidas. No podemos prever el horario de la parada, ni la ruta, ya que ser&aacute; organizado una vez recibidas todas las inscripciones. Esto requiere cierta flexibilidad por su parte, ya que el horario de la parada elegida podr&iacute;a variar.<br>
  En <a href="https://www.dsbilbao.org/cursos-de-idiomas/campus-de-verano/transporte/">Horarios de autob&uacute;s</a>&nbsp;se pueden ver los recorridos en el Campus de verano 2023 con car&aacute;cter orientativo.</div>

<div <?php echo $stylelabmargin; ?>>
  <span <?php echo $stylelabrequired; ?>>Bus ida </span>
  <strong><?php echo strip_tags($POSTsaneEmail['Busida']) ?></strong>
</div>
<div <?php echo $stylelabmargin; ?>>
  <span <?php echo $stylelabrequired; ?>>Bus vuelta </span>
  <strong><?php echo strip_tags($POSTsaneEmail['Busvuelta']) ?></strong>
</div>
<div <?php echo $stylelabmargin; ?>>
  <span <?php echo $stylelabrequired; ?>>Bus vuelta </span>
  <strong><?php echo strip_tags($POSTsaneEmail['Busvuelta2']) ?></strong>
</div>
<div <?php echo $stylemainlegend; ?>>Alumno/a:</div>

<?php
$sum = 0;
$optionssumme = 0;
$key = 'nombre0';
$currentWeekGuaderia = false;
$currentWeekComedor = false;

if (array_key_exists($key, $POSTsaneEmail)) {
  //echo "&nbsp;" 
?>


  <div <?php echo $stylelabmargin; ?>>
    <span <?php echo $stylekidlabrequired; ?>>Nombre </span>
    <strong>
      <?php $key = 'nombre0';
      echo strip_tags($POSTsaneEmail[$key]) ?>
    </strong>
  </div>

  <div <?php echo $stylelabmargin; ?>>
    <span <?php echo $stylekidlabrequired; ?>>Apellidos </span>
    <strong>
      <?php $key = 'apellidos0';
      echo strip_tags($POSTsaneEmail[$key]) ?>
    </strong>
  </div>

  <div <?php echo $stylelabmargin; ?>>
    <span <?php echo $stylekidlabrequired; ?>>Fecha de nacimiento </span>
    <strong>
      <?php $key = 'birthdate0';
      echo strip_tags($POSTsaneEmail[$key]) ?>
    </strong>
  </div>

  <div <?php echo $stylelabmargin; ?>>
    <span <?php echo $stylekidlabrequired; ?>>Colegio habitual de la ense&ntilde;anza reglada </span>
    <strong>
      <?php $key = 'colegio0';
      $colegio = trim(strip_tags($POSTsaneEmail[$key]));
      echo $colegio; ?>
    </strong>
  </div>

  <div <?php echo $stylelabmargin; ?>>
    <span <?php echo $stylekidlabrequired; ?>>&iquest;Sabe nadar sin ayuda? </span>
    <strong>
      <?php $key = 'nadar0';
      echo strip_tags($POSTsaneEmail[$key]) ?>
    </strong>
  </div>

  <div style="margin-top: 5px; padding-top: 3px;">
    <span <?php echo $stylekidlabrequired; ?>>&iquest;Tiene autorizaci&oacute;n para ba&ntilde;arse en las piscinas hinchables infantiles bajo la supervisi&oacute;n del profesor/a? </span>
    <strong>
      <?php $key = 'autohinch0';
      echo strip_tags($POSTsaneEmail[$key]) ?>
    </strong>
  </div>

  <div style="margin-top: 5px; padding-top: 3px;">
    <span <?php echo $stylekidlabrequired; ?>>&iquest;Tiene autorizaci&oacute;n para ba&ntilde;arse en la piscina grande bajo la supervisi&oacute;n del socorrista? </span>
    <strong>
      <?php $key = 'autopisci0';
      echo strip_tags($POSTsaneEmail[$key]) ?>
    </strong>
  </div>

  <?php $key = 'alergias0';
  $content = strip_tags($POSTsaneEmail[$key]);
  if (strlen(trim($content)) > 0) { ?>
    <div style="margin-left: 0px; margin-bottom: 1px; margin-top: 6px;padding-top:15px;margin-right: 0px; overflow: hidden;">
      <span <?php echo $stylekidlabrequired; ?>> Alergias </span>
      <strong>&nbsp;<?php echo "$content"; ?></strong>
    </div>
  <?php }

  $key = 'intolerancias0';
  $content = strip_tags($POSTsaneEmail[$key]);
  if (strlen(trim($content)) > 0) { ?>
    <div style="clear: left;margin-left: 0px; margin-bottom: 1px; margin-top: 3px; margin-right: 0px; overflow: hidden;">
      <span <?php echo $stylekidlabrequired; ?>> Intolerancias a alimentos </span>
      <strong>&nbsp;<?php echo "$content"; ?></strong>
    </div>
  <?php }

  $key = 'medicaciones0';
  $content = strip_tags($POSTsaneEmail[$key]);
  if (strlen(trim($content)) > 0) { ?>
    <div style="clear: left;margin-left: 0px; margin-bottom: 6px; margin-top: 3px; margin-right: 0px; overflow: hidden; _height: 0.1%;">
      <span <?php echo $stylekidlabrequired; ?>> Medicaciones </span>
      <strong>&nbsp;<?php echo "$content"; ?></strong>
    </div>
  <?php } ?>

  <div <?php echo $stylelegend; ?>>El curso al cual se le apunta:<strong>
      <?php
      $cumpleISO = date("Y-m-d", strtotime(strip_tags($POSTsaneEmail['birthdate0'])));
      //echo $cumpleISO;
      $kursName = getKursName($KursNameJung, $KursNameAlt, $cumpleISO, $stichtagkurs); //siehe cursossemanasprecios.php 					 
      echo $kursName;
      ?></strong></div>

  <div style="clear: left; margin-top: 5px; padding-top: 5px;">
    <span <?php echo $stylekidlabrequired; ?>>Idioma </span>
    <strong>
      <?php
      $key = 'idioma0';
      $idiomastr = strip_tags($POSTsaneEmail[$key]);
      echo $idiomastr; ?>
    </strong>
  </div>

  <?php
  $showExamen = false;
  /*  
          if (($kursoptions0[0][0]==3) ||
          ($kursoptions0[0][1]==3) ||
          ($kursoptions0[0][2]==3) ||
          ($kursoptions0[0][3]==3) ||
          ($kursoptions0[0][4]==3)) {
          $showExamen = true;						?>
        <div style="clear: left; margin-top: 5px; padding-top: 5px;">      
        <span style="font-weight:lighter!important;">&nbsp;&nbsp;Opci&oacute;n: </span>
        <strong>Especial preparatorio para examen oficial para j&oacute;venes y adultos a partir de 13/14 a&ntilde;os</strong>
      </div>	
      <?php } else 
          $showExamen = false;*/ ?>

  <div style="clear: left; margin-top: 5px; padding-top: 5px;">
    <span <?php echo $stylekidlabrequired; ?>>Observaciones con respecto al nivel en este idioma </span><br />
    <strong>
      <?php $key = 'obsidioma0';
      echo strip_tags($POSTsaneEmail[$key]) ?>
    </strong>
  </div>

  <div style="clear: left; margin-top: 5px; padding-top: 5px;">
    <p>
      <span style="font-weight: bold; color: #0085CA; margin-left: 15px; color: #0085CA;"> El curso completo del alumno/a:</span>
      <?php
      $tablestyle = " style=\"border-collapse: collapse; border-spacing: 0px; margin: auto; border: 0px solid transparent;padding: 5px;margin-left:24px;width:98%;\"";
      $tdstyle = "style=\"border-bottom: 1px solid #BBBBBB;padding: 5px\"";
      ?>
    <table class="table table-striped showtable" <?php echo $tablestyle; ?>>
      <tbody>
        <thead>
          <tr>
            <th <?php echo $tdstyle; ?>>Semana</th>
            <th <?php echo $tdstyle; ?>>
              <center><?php echo $zoption[1]; ?></center>
            </th>
            <th <?php echo $tdstyle; ?>>
              <center><?php echo $zoption[2]; ?></center>
            </th>
          </tr>
        </thead>


        <?php
        $prize = $cursoinscrpcion;
        $prizeoptions = 0;
        $hkurs_woche = $kurs_woche0;
        $kursoptions = $kursoptions0;

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


        $wochenanzahl = 0;
        for ($idx = 0; $idx < 6; $idx++) {
          if (isset($hkurs_woche[$idx]) && $hkurs_woche[$idx] > 'w0') {
            echo "<tr>";
            echo "<td $tdstyle>";
            $currentWeekIdx = intval(substr($hkurs_woche[$idx], -1));
            $wochenanzahl++;
            //Precio jede woche einzeln
            //$prize = $prize + $cursoprecio[$currentWeekIdx] + $zusatzpreis;
            //if ($fruehchecks[$currentWeekIdx]) $prizeoptions  = $prizeoptions + $fruehcursoprecio[$currentWeekIdx];
            //if ($mittagchecks[$currentWeekIdx]) $prizeoptions = $prizeoptions + $mittagcursoprecio[$currentWeekIdx];						

            echo "Semana $currentWeekIdx: <span style='font-weight:normal;'>" . $week[$currentWeekIdx] . " </span>" . $cursoprecio[$currentWeekIdx][$preisindex] . "&euro; ";
            //$currentWeekIdx=0;//diese zeile weg, wenn man die Optionen wochenweise wählen kann
            echo "</td><td $tdstyle><center>";
            if ($fruehchecks[$currentWeekIdx]) echo "<span style='font-weight:normal;'>si</span> " . $fruehcursoprecio[$currentWeekIdx] . "&euro; ";
            else "no";
            echo "</center></td><td $tdstyle><center>";
            if ($mittagchecks[$currentWeekIdx]) echo "<span style='font-weight:normal;'>si</span> " . $mittagcursoprecio[$currentWeekIdx]  . "&euro; ";
            else "no";
            echo "</center></td></tr>";
          }
        }
        //das wenn preis je nach Anzahl wochen
        //$prize = $prize + $cursoprecio[$wochenanzahl];

        //Preisberechnung Discounts 2024	 
        $preis = 1.0 * $prize;

        $discount1active = ($wochenanzahl == 4); //Mehrere Wochen	   
        $discount2active = ($colegio == "DSB"); //DSB sch�ler
        $discount3active = isEarlyBird(); //Early Bird

        $discountactive[1] = $discount1active;
        $discountactive[2] = $discount2active;
        $discountactive[3] = $discount3active;

        //berechne Preis mit allen Discounts

        //list($newprice, $discountstring,$vollerpreis,$gesamtrabatt) = calculatePricewithDiscounts($preis, $prizeoptions, $discount1percent, $discount2percent, $discount3percent, $discount1active, $discount2active, $discount3active, $discount1name, $discount2name, $discount3name);
        list($newprice, $discountstring, $vollerpreis, $gesamtrabatt)  = calculatePricewithDiscounts($selectedweeks, $fruehselectedweeks, $mittagselectedweeks, $cursoprecio, $fruehcursoprecio, $mittagcursoprecio, $discountactive, $discountnames);

        if ($discount3active) $VorStichtag = 1;
        else $VorStichtag = 0;

        $prizetext = $discountstring;
        $prize = $newprice;


        $primerpago = 0;
        $segundopago = $prize - $primerpago;
        if ($segundopago > 0) {
          $segundopagotext = "Segundo pago: $segundopago Euros hasta el 31 de mayo 2024.";
        } else {
          $segundopagotext = "";
        }

        if ($currentWeekGuaderia) echo "</tr><td>&nbsp;&nbsp;" . $cursovaluep[$wochenanzahl] . " " . $zoption[1] . "</td></tr>";
        if ($currentWeekComedor)  echo "</tr><td>&nbsp;&nbsp;" . $cursovaluep[$wochenanzahl] . " " . $zoption[2] . "</td></tr>";
        $gesamthijo = $prize;
        //neu 2024 Ausgabe Preistext $prizetext
        echo "<tr><td colspan=\"3\" align=\"left\" style='font-size:larger;'>Precio final <strong>$prizetext</strong></td></tr>";
        /*echo "<tr><td align=\"left\">Precio total: <strong>$gesamthijo  &euro;</strong></td></tr>";
              echo "<tr><td align=\"left\" style='font-size:larger;'>Precio total: <strong>$gesamthijo  &euro;</strong>&nbsp;&nbsp;(Primer pago:&nbsp;260 Euros el d&iacute;a de la inscripci&oacute;n, o unos d&iacute;as antes o despu&eacute;s de la misma. $segundopagotext)</td></tr>";*/
        ?>
      </tbody>
    </table>
  <?php } //if (array_key_exists($key, $POSTsaneEmail) )
  ?>
  </div>
  <?php //curso completo
  ?>

  <?php //</div> hija abschnitt
  ?>

  <div <?php echo $stylelegend ?>>C&oacute;mo han conocido nuestra oferta de los campus de verano en alem&aacute;n, ingl&eacute;s o franc&eacute;s en el Colegio Alem&aacute;n:</div>
  <div class="field" style="clear:both;">
    <span style="padding-left:26px" id="infoKursFundort" name="infoKursFundort"><?php echo strip_tags($POSTsaneEmail['infoKursFundort']); ?></span>
  </div>
  </div>

  <div id="poteccion">
    <div <?php echo $stylelegend ?>>Han aceptado la siguiente cl&aacute;usula respecto a la protecci&oacute;n de datos personales:</div>
    <blockquote style="color: #606060;font-weight:200!important;">
      <?php include_once("clausula.php"); ?>
    </blockquote>
  </div>
  </div>