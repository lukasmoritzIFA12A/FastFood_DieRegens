<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\components\postbox\PostboxLogic;

// Postbox-Logic
$postBoxLogic = new PostboxLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user'])) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Nutzer nicht eingeloggt!"]);
        exit;
    }

    $postboxId = $_POST['id'];

    if ($postBoxLogic->deleteNachricht($postboxId)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $postBoxLogic->errorMessage]);
    }
    $_FILES = array();
}

exit;