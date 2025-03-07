<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\admin\AdminLogic;
use Doctrine\Common\Collections\ArrayCollection;

// Admin-Logic
$adminLogic = new AdminLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_FILES['bild'])) {
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Kein Bild angegeben!"]);
        exit;
    }

    if ($_FILES['bild']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Fehler bei dem Upload des Bildes!"]);
        exit;
    }

    $fileInfo = pathinfo($_FILES['bild']['name']);
    $fileExtension = $fileInfo['extension'];
    if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
        echo json_encode(["success" => false, "message" => "Ungültiges Dateiformat"]);
        exit;
    }

    $fileSize = $_FILES['bild']['size'];
    $fileType = mime_content_type($_FILES['bild']['tmp_name']);
    $allowedTypes = ['image/jpeg', 'image/png']; // Beispiel für erlaubte Dateitypen

    if ($fileSize > 5000000) { // max. 5MB (du kannst den Wert nach Bedarf anpassen)
        echo json_encode(["success" => false, "message" => "Die Datei ist zu groß!"]);
        exit;
    }

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(["success" => false, "message" => "Ungültiger Dateityp!"]);
        exit;
    }

    $tempPath = $_FILES['bild']['tmp_name'];
    $titel = $_POST['titel'];
    $beschreibung = $_POST['beschreibung'];
    $rawprodukte = $_POST['produkte'];
    $rawprodukteArray = explode(',', $rawprodukte);

    $produkteCollection = new ArrayCollection();
    foreach ($rawprodukteArray as $rawprodukt) {
        if (is_numeric($rawprodukt)) {
            $produkteCollection->add(intval($rawprodukt));
        }
    }

    /* if (!isset($_SESSION['admin'])) {
         echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Kein Admin eingeloggt!"]);
         exit;
     }*/

    if ($adminLogic->saveMenue($titel, $beschreibung, $tempPath, $produkteCollection)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $adminLogic->errorMessage]);
    }
}

exit;