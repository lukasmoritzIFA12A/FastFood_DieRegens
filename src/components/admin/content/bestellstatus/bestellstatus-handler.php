<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\components\admin\AdminLogic;

// Admin-Logic
$adminLogic = new AdminLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['admin'])) {
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Kein Admin eingeloggt!"]);
        exit;
    }

    $orderStatus = $_POST['status'];
    $orderStatusColor = $_POST['farbe'];

    if ($adminLogic->saveBestellstatus($orderStatus, $orderStatusColor)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $adminLogic->errorMessage]);
    }
}

exit;