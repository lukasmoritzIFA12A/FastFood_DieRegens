<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../../../vendor/autoload.php';

use App\components\kundenverwaltung\account\AccountLogic;

// Account-Logic
$accountLogic = new AccountLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newTelefon = $_POST['newTelefon'];

    if (!isset($_SESSION['user'])) {
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Nutzer nicht eingeloggt!"]);
        exit;
    }

    if ($accountLogic->updateTelefon($_SESSION['user'], $newTelefon)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $accountLogic->errorMessage]);
    }
}