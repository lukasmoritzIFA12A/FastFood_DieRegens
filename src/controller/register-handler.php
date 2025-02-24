<?php
session_start();

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../vendor/autoload.php';

use App\controller\RegisterLogic;
use App\datenbank\Entitaeten\Adresse;
use App\datenbank\Entitaeten\Kunde;

// Register-Logik
$registerLogic = new RegisterLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//Adresse aufbauen
    $strasse = $_POST['street'];
    $hausnummer = $_POST['house_number'];
    $stadt = $_POST['city'];
    $plz = $_POST['postleitzahl'];
    $zusatz = $_POST['zusatz'];

    $adresse = $registerLogic->createAdresse($strasse, $hausnummer, $stadt, $plz, $zusatz);
    if (!$adresse) {
        echo json_encode(["success" => false, "message" => $registerLogic->errorMessage]);
        exit;
    }

//Login aufbauen
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password_confirm = $_POST['confirm_password'];

    $login = $registerLogic->createLogin($username, $password, $password_confirm);
    if (!$login) {
        echo json_encode(["success" => false, "message" => $registerLogic->errorMessage]);
        exit;
    }

//Kunde aufbauen
    $vorname = $_POST['first_name'];
    $nachname = $_POST['last_name'];
    $telefonnummer = $_POST['telefon_nummer'];

    $kunde = $registerLogic->createKunde($login, $adresse, $vorname, $nachname, $telefonnummer);
    if (!$kunde) {
        echo json_encode(["success" => false, "message" => $registerLogic->errorMessage]);
        exit;
    }

    if ($registerLogic->registrieren($kunde)) {
        $_SESSION['user'] = $username;
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $registerLogic->errorMessage]);
    }
}

exit;
