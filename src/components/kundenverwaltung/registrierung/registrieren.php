<?php
//TODO Hier überprüfen, ob das Formular abgesendet wurde
/*if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formular-Daten erhalten
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $email = $_POST['email'];*/

    //TODO zusätzliche Validierungen und Datenbank-Checks einfügen

    //TODO Erstelle Account in der Datenbank

    // Erfolgreiche Registrierung
    echo "Account erfolgreich erstellt!";

    // Weiterleitung zur Startseite
    header('Location: ../view/startseite.php');
    exit;
/*} else {
    // Falls die Seite direkt aufgerufen wird (ohne das Formular abzusenden)
    echo "Bitte fülle das Formular aus!";
}*/
?>
