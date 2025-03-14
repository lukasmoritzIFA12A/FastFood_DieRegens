<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../vendor/autoload.php';

use App\components\warenkorb\WarenkorbLogic;

// Warenkorb-Logic
$warenkorbLogic = new WarenkorbLogic();

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $bestellungMenues = [];
    if (isset($_SESSION['warenkorb']['menues'])) {
        $bestellungMenues = $_SESSION['warenkorb']['menues'];
    }

    $bestellungProdukte = [];
    if (isset($_SESSION['warenkorb']['produkte'])) {
        $bestellungProdukte = $_SESSION['warenkorb']['produkte'];
    }

    $kunde = $warenkorbLogic->getEingeloggterKunde($_SESSION['user']);
    if (!$kunde) {
        echo json_encode(["success" => false, "message" => "Kein eingeloggter Kunde!"]);
        exit;
    }

    if (isset($_SESSION['lieferadresseWasEdited']) && $_SESSION['lieferadresseWasEdited'] === '1') {
        $kunde = $warenkorbLogic->getSessionLieferKunde($kunde);
    }

    $rabatt = null;
    if (isset($_SESSION['rabattcode'])) {
        $rabatt = $warenkorbLogic->getRabatt($_SESSION['rabattcode']);
    }

    $trinkgeld = null;
    if (isset($_SESSION['trinkgeld'])) {
        $trinkgeld = $_SESSION['trinkgeld'];
    }

    if (!isset($_SESSION['zahlungsmethode'])) {
        echo json_encode(["success" => false, "message" => "Keine Zahlungsart vorhanden!"]);
        exit;
    }
    $zahlungsmethodeId = $_SESSION['zahlungsmethode'];

    $bestellung = $warenkorbLogic->saveBestellung($bestellungMenues, $bestellungProdukte, $kunde, $rabatt, $trinkgeld, $zahlungsmethodeId);
    if ($bestellung) {
        $warenkorbLogic->unsetWarenkorb();
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => $warenkorbLogic->errorMessage]);
    }
}

exit;