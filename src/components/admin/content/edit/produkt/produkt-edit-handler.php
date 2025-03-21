<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../../../vendor/autoload.php';

use App\components\admin\AdminLogic;
use App\datenbank\Entitaeten\Energiewert;
use Doctrine\Common\Collections\ArrayCollection;

// Admin-Logic
$adminLogic = new AdminLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['admin'])) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Kein Admin eingeloggt!"]);
        exit;
    }

    if (!isset($_FILES['bild'])) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Kein Bild angegeben!"]);
        exit;
    }

    if ($_FILES['bild']['error'] !== UPLOAD_ERR_OK) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Fehler bei dem Upload des Bildes!"]);
        exit;
    }

    $fileInfo = pathinfo($_FILES['bild']['name']);
    $fileExtension = $fileInfo['extension'];
    if (!in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png'])) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Ungültiges Dateiformat"]);
        exit;
    }

    $fileSize = $_FILES['bild']['size'];
    $fileType = mime_content_type($_FILES['bild']['tmp_name']);
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

    $tempPath = $_FILES['bild']['tmp_name'];

    $titel = $_POST['titel'];
    $beschreibung = $_POST['beschreibung'];
    $preis = $_POST['preis'];
    $istAusverkauft = $_POST['ausverkauft'] ?? false;
    $rawzutaten = $_POST['zutaten'];
    $rawzutatenArray = explode(',', $rawzutaten);

    $zutatenCollection = new ArrayCollection();
    foreach ($rawzutatenArray as $rawzutat) {
        if (is_numeric($rawzutat)) {
            $zutatenCollection->add(intval($rawzutat));
        }
    }

    if (isset($_SESSION['portionSize'])) {
        $energiewert = new Energiewert();
        $energiewert->setPortionSize($_SESSION['portionSize']);
        $energiewert->setKalorien($_SESSION['kalorien']);
        $energiewert->setFett($_SESSION['fett']);
        $energiewert->setKohlenhydrate($_SESSION['kohlenhydrate']);
        $energiewert->setZucker($_SESSION['zucker']);
        $energiewert->setEiweiss($_SESSION['eiweiss']);
    } else {
        $energiewert = null;
    }

    if (isset($_POST['id'])) {
        if ($adminLogic->updateProdukt($_POST['id'], $titel, $beschreibung, $preis, $tempPath, $istAusverkauft, $zutatenCollection, $energiewert)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => $adminLogic->errorMessage]);
        }
    }
    $_FILES = array();
}

exit;