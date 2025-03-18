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
    $adminLogic->unsetEnergiewerteSession();

    if (!isset($_SESSION['admin'])) {
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Kein Admin eingeloggt!"]);
        exit;
    }

    if (!isset($_POST['portionSize'])) {
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Keine Energiewerte angegeben!"]);
        exit;
    }

    $_SESSION['portionSize'] = $_POST['portionSize'];
    $_SESSION['kalorien'] = $_POST['kalorien'];
    $_SESSION['fett'] = $_POST['fett'];
    $_SESSION['kohlenhydrate'] = $_POST['kohlenhydrate'];
    $_SESSION['zucker'] = $_POST['zucker'];
    $_SESSION['eiweiss'] = $_POST['eiweiss'];

    echo json_encode(["success" => true]);
}

exit;