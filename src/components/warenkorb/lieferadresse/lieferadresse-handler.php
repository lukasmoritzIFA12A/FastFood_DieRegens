<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\warenkorb\WarenkorbLogic;

// Warenkorb-Logic
$warenkorbLogic = new WarenkorbLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user'])) {
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Nutzer nicht eingeloggt!"]);
        exit;
    }

    $_SESSION['lieferadresseWasEdited'] = '1';
    $_SESSION['newStreet'] = $_POST['newStreet'];
    $_SESSION['newNumber'] = $_POST['newNumber'];
    $_SESSION['newPostalCode'] = $_POST['newPostalCode'];
    $_SESSION['newCity'] = $_POST['newCity'];
    $_SESSION['newZusatz'] = $_POST['newZusatz'];
    $_SESSION['newVorname'] = $_POST['newVorname'];
    $_SESSION['newNachname'] = $_POST['newNachname'];
    $_SESSION['newTelefonnummer'] = $_POST['newTelefonnummer'];

    echo json_encode(["success" => true]);
}

exit;