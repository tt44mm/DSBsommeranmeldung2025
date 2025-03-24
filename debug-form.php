<?php
// Diese Datei hilft beim Debuggen der Formulardaten
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Form Data</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #003366; }
        .data-section { background: #f5f5f5; padding: 10px; margin: 10px 0; border-radius: 5px; }
        .data-section pre { background: white; padding: 10px; border: 1px solid #ddd; overflow: auto; }
        .error { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Formular Debug-Ansicht</h1>
    
    <div class="data-section">
        <h2>POST Daten</h2>
        <pre><?php print_r($_POST); ?></pre>
    </div>
    
    <div class="data-section">
        <h2>FILES Daten</h2>
        <pre><?php print_r($_FILES); ?></pre>
    </div>
    
    <?php if (isset($_POST['encryptedpost'])): ?>
    <div class="data-section">
        <h2>Entschlüsselte POST Daten</h2>
        <?php
        require_once 'includes/formvalidator.php';
        $decrypted = decode_arr($_POST['encryptedpost']);
        ?>
        <pre><?php print_r($decrypted); ?></pre>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_POST['encryptedkurs_woche0']) && $_POST['encryptedkurs_woche0'] != '0'): ?>
    <div class="data-section">
        <h2>Entschlüsselte Kurswoche Daten</h2>
        <?php
        $kurs_woche = decode_arr($_POST['encryptedkurs_woche0']);
        ?>
        <pre><?php print_r($kurs_woche); ?></pre>
    </div>
    <?php endif; ?>
    
    <?php if (isset($_POST['encryptedkurs_options0']) && $_POST['encryptedkurs_options0'] != '0'): ?>
    <div class="data-section">
        <h2>Entschlüsselte Kursoptionen Daten</h2>
        <?php
        $kurs_options = decode_arr($_POST['encryptedkurs_options0']);
        ?>
        <pre><?php print_r($kurs_options); ?></pre>
    </div>
    <?php endif; ?>
    
    <div class="data-section">
        <h2>Definierte Variablen</h2>
        <?php 
        // Lade die benötigten Dateien
        require_once 'includes/cursossemanasprecios_2025.php';
        ?>
        <p>$cursovalue definiert: <?php echo isset($cursovalue) ? 'Ja' : '<span class="error">Nein</span>'; ?></p>
        
        <?php if (isset($cursovalue)): ?>
        <pre><?php print_r($cursovalue); ?></pre>
        <?php endif; ?>
    </div>

    <div class="data-section">
        <h2>Debugging Database Connection</h2>
        <?php
        // Überprüfe die Datenbankverbindung
        require_once 'includes/objects/connect_data.php';
        echo "<p>Datenbankparameter:</p>";
        echo "<ul>";
        echo "<li>Server: " . (isset($server) ? $server : '<span class="error">nicht definiert</span>') . "</li>";
        echo "<li>Datenbank: " . (isset($db) ? $db : '<span class="error">nicht definiert</span>') . "</li>";
        echo "<li>Benutzer: " . (isset($user) ? $user : '<span class="error">nicht definiert</span>') . "</li>";
        echo "<li>Tabelle: " . (isset($tablename_cfamaccept) ? $tablename_cfamaccept : '<span class="error">nicht definiert</span>') . "</li>";
        echo "</ul>";
        
        // Überprüfe die Zeichenkodierung
        if (isset($server) && isset($user) && isset($pass)) {
            $conn = mysqli_connect($server, $user, $pass);
            if ($conn) {
                echo "<p class='success'>Verbindung zum MySQL-Server erfolgreich!</p>";
                
                if (isset($db)) {
                    $dbSelect = mysqli_select_db($conn, $db);
                    if ($dbSelect) {
                        echo "<p class='success'>Datenbank '$db' erfolgreich ausgewählt!</p>";
                        
                        // Überprüfe die Tabelle
                        if (isset($tablename_cfamaccept)) {
                            $query = "SHOW TABLES LIKE '$tablename_cfamaccept'";
                            $result = mysqli_query($conn, $query);
                            if ($result && mysqli_num_rows($result) > 0) {
                                echo "<p class='success'>Tabelle '$tablename_cfamaccept' existiert!</p>";
                                
                                // Zeige die Tabellenstruktur
                                $query = "DESCRIBE $tablename_cfamaccept";
                                $result = mysqli_query($conn, $query);
                                echo "<p>Tabellenstruktur:</p>";
                                echo "<pre>";
                                while ($row = mysqli_fetch_assoc($result)) {
                                    print_r($row);
                                }
                                echo "</pre>";
                            } else {
                                echo "<p class='error'>Tabelle '$tablename_cfamaccept' existiert nicht!</p>";
                            }
                        }
                    } else {
                        echo "<p class='error'>Fehler beim Auswählen der Datenbank: " . mysqli_error($conn) . "</p>";
                    }
                }
                
                mysqli_close($conn);
            } else {
                echo "<p class='error'>Fehler bei der Verbindung zum MySQL-Server: " . mysqli_connect_error() . "</p>";
            }
        }
        ?>
    </div>

    <div class="data-section">
        <h2>Weiterleitung zum Formular</h2>
        <p><a href="anmeldungsommercamp_2025.php">Zurück zum Anmeldeformular</a></p>
    </div>
</body>
</html> 