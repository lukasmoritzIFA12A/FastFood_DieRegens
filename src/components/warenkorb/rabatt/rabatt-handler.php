<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\warenkorb\WarenkorbLogic;

// Warenkorb-Logic
$warenkorbLogic = new WarenkorbLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['rabattcode'])) {
        unset($_SESSION['rabattcode']);
        unset($_SESSION['rabatt']);
        echo json_encode(["success" => true]);
        exit;
    }

    $rabattcode = $_POST['rabattcode'];
    $rabatt = $warenkorbLogic->getRabatt($rabattcode);
    if ($rabatt) {
        $_SESSION['rabatt'] = $rabatt->getMinderung();
        $_SESSION['rabattcode'] = $rabattcode;

        echo json_encode(["success" => true, "rabatt" => $rabatt->getMinderung(), "rabattcode" => $rabattcode]);
    } else {
        echo json_encode(["success" => false, "message" => $warenkorbLogic->errorMessage]);
    }
}

exit;