<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\kundenverwaltung\login\LoginLogic;

// Login-Logik
$loginLogic = new LoginLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginId = $loginLogic->einloggen($username, $password);
    if ($loginId) {
        $_SESSION['user'] = $username;

        if ($loginLogic->istAdmin($loginId)) {
            $_SESSION['admin'] = true;
        }

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $loginLogic->errorMessage]);
    }
}

exit;