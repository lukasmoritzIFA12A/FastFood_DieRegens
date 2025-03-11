<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\admin\AdminLogic;

// Admin-Logic
$adminLogic = new AdminLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['admin'])) {
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Kein Admin eingeloggt!"]);
        exit;
    }

    $produktId = $_POST['energiewertProdukte'];
    $portionSize = $_POST['portionSize'];
    $kalorien = $_POST['kalorien'];
    $fett = $_POST['fett'];
    $kohlenhydrate = $_POST['kohlenhydrate'];
    $zucker = $_POST['zucker'];
    $eiweiss = $_POST['eiweiss'];

    if ($adminLogic->saveEnergieWerte($produktId, $portionSize, $kalorien, $fett, $kohlenhydrate, $zucker, $eiweiss)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $adminLogic->errorMessage]);
    }
}

exit;