<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\funnyDinnerContest\ContestLogic;

// Contest-Logic
$contestLogic = new ContestLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user'])) {
        $_FILES = array();
        echo json_encode(["success" => false, "message" => "Unerwarteter Fehler: Nutzer nicht eingeloggt!"]);
        exit;
    }

    $contestId = $_POST['id'];
    $rating = $_POST['rating'];
    $kundeId = $_POST['kundeId'];

    if ($contestLogic->saveRating($contestId, $rating, $kundeId)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $contestLogic->errorMessage]);
    }
    $_FILES = array();
}

exit;