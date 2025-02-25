<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\components\kundenverwaltung\account\AccountLogic;

// Account-Logik
$accountLogik = new AccountLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newBenutzername = $_POST['newBenutzername'];

    if ($loginLogic->einloggen($username, $password)) {
        $_SESSION['user'] = $username;
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $loginLogic->errorMessage]);
    }
}