# Konfiguration

## Datenbankverbindung

1. Öffnen Sie die Datei `includes/connect_data.php`
2. Tragen Sie die Datenbankzugangsdaten ein:
   ```php
   $host = "localhost";
   $user = "your_database_user";
   $password = "your_database_password";
   $database = "your_database_name";
   ```

## E-Mail-Konfiguration

1. PHPMailer-Einstellungen in `includes/sendemail.php` anpassen:
   - SMTP-Server
   - Port
   - Authentifizierung
   - Absender-E-Mail

## Formular-Einstellungen

1. Preise und Kurse in `includes/cursossemanasprecios_2025.php` anpassen
2. Validierungsregeln in `js/js-functions.js` überprüfen und ggf. anpassen
3. Spracheinstellungen und Texte in den PHP-Dateien anpassen
