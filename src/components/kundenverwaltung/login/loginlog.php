<?php

use Src\Utils\Router;
require_once __DIR__ . '/../../../utils/router.php';
// Hier wird überprüft, ob das Formular abgesendet wurde
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formular-Daten erhalten
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hier Logik hinzufügen, um die Login-Daten in der Datenbank zu überprüfen
    // Beispiel: Benutzer aus der DB holen und Passwort verifizieren

    // Für Test Benutzername "admin" und das Passwort "pass" ist

    //if ($username == 'admin' && $password == 'pass') {
        // Erfolgreicher Login
        echo "Erfolgreich eingeloggt!";

        // Weiterleitung zur Startseite
        header(Router::url('/components/startseite/startseite.php'));
        exit;
    /*} else {
        // Fehlerhafte Login-Daten
        echo "Ungültiger Benutzername oder Passwort!";
    }*/
}
?>
