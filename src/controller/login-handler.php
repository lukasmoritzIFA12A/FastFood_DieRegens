<?php
session_start();

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../vendor/autoload.php';

use App\controller\LoginLogic;

// Login-Logik
$loginLogic = new LoginLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($loginLogic->einloggen($username, $password)) {
        $_SESSION['user'] = $username;
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $loginLogic->errorMessage]);
    }
}

exit;