<?php
$spra = "spa";
$title[$spra] = "Inscripcion - Cursos Verano 2025";
$menuID = 3;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title[$spra]; ?></title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/dsbform_2.css" />
  <link rel="stylesheet" type="text/css" href="css/validation-styles.css" />
  <link rel="stylesheet" type="text/css" href="css/cursosprint.css" media="print" />

<?php 
// Nur wenn jQuery verwendet werden soll
if ($usejquery == true) { ?>
  <script src="js/jquery-latest.pack.js" type="text/javascript"></script>
<?php } ?>

<script type="text/javascript">
function isEarlyBird() {
  // Create a new Date object with the current date
  const currentDate = new Date();
  
  // Create a new Date object for June 1, 2025
  const juneFirst2025 = new Date('2025-06-01'); //2025-06-01 = 1.Juni 2025
  
  // Compare the two dates and return true if the current date is before June 1, 2025
  return currentDate < juneFirst2025;
}

function weekclick(indexstr) {
  // Implementierung der weekclick-Funktion, die in der Hauptdatei benötigt wird
  // Details wurden bereits in js-functions.js verschoben
}

function dsbclicksi(indexstr) {
  // Implementierung der dsbclicksi-Funktion
  // Details wurden bereits in js-functions.js verschoben  
}

function dsbclickno(indexstr) {
  // Implementierung der dsbclickno-Funktion
  // Details wurden bereits in js-functions.js verschoben
}

function idiomaclick(indexstr) {
  // Implementierung der idiomaclick-Funktion
  // Details wurden bereits in js-functions.js verschoben
}

function colegioclick(indexstr) {
  // Implementierung der colegioclick-Funktion
  // Details wurden bereits in js-functions.js verschoben
}

function submitclick() {
  // Implementierung der submitclick-Funktion
  // Details wurden bereits in js-functions.js verschoben
  return true;
}
</script>

<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"></script>

</head>

<body>
  <div id="content">