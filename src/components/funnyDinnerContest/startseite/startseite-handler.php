<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\funnyDinnerContest\ContestLogic;

// Contest-Logic
$contestLogic = new ContestLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user'])) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Nutzer nicht eingeloggt!"]);
        exit;
    }

    if (!isset($_FILES['fileInput'])) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Kein Bild angegeben!"]);
        exit;
    }

    if ($_FILES['fileInput']['error'] !== UPLOAD_ERR_OK) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Fehler bei dem Upload des Bildes!"]);
        exit;
    }

    $fileInfo = pathinfo($_FILES['fileInput']['name']);
    $fileExtension = $fileInfo['extension'];
    if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Ungültiges Dateiformat"]);
        exit;
    }

    $fileSize = $_FILES['fileInput']['size'];
    $fileType = mime_content_type($_FILES['fileInput']['tmp_name']);
    $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg']; // Beispiel für erlaubte Dateitypen

    if ($fileSize > 5000000) { // max. 5MB (du kannst den Wert nach Bedarf anpassen)
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Die Datei ist zu groß!"]);
        exit;
    }

    if (!in_array($fileType, $allowedTypes)) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Ungültiger Dateityp!"]);
        exit;
    }

    $tempPath = $_FILES['fileInput']['tmp_name'];
    $bestellId = $_POST['id'];

    if ($contestLogic->saveContest($bestellId, $tempPath)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $contestLogic->errorMessage]);
    }
    $_FILES = array();
}

exit;