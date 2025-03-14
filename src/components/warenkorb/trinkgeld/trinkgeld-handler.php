<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['trinkgeld'] = $_POST['trinkgeld'];
    $_SESSION['andereTrinkgeld'] = $_POST['andereTrinkgeld'];

    echo json_encode(["success" => true]);
}

exit;