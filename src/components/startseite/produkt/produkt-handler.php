<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header("Content-Type: application/json"); // Sagen, dass wir JSON zurückgeben

require_once __DIR__ . '/../../../../vendor/autoload.php';

// Prüfen, ob ein POST-Request vorliegt
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user'])) {
        echo json_encode(["success" => false, "loggedIn" => false]);
        exit;
    }

    if (!isset($_SESSION['warenkorb'])) {
        $_SESSION['warenkorb'] = [
            'menues' => [],
            'produkte' => []
        ];
    }

    if (!isset($_POST['productId']) && !isset($_POST['warenkorbIndex'])) {
        echo json_encode(["success" => false, "message" => "Schwerwiegender Fehler: Produkt ID/Index ist benötigt!"]);
        exit;
    }

    if (isset($_POST['productId'])) {
        $anzahl = $_POST['produktAnzahl'] ?? "1";

        if (!isset($_SESSION['warenkorb']['produkte'][$_POST['productId']])) {
            $_SESSION['warenkorb']['produkte'][$_POST['productId']] = $anzahl; // Erstes Vorkommen
        } else {
            $_SESSION['warenkorb']['produkte'][$_POST['productId']] += $anzahl; // Menge erhöhen
        }

        echo json_encode(["success" => true]);
        exit;
    }

    $index = $_POST['warenkorbIndex'];
    if (isset($_SESSION['warenkorb']['produkte'][$index])) {
        $anzahl = $_POST['produktAnzahl'] ?? "1";

        if (intval($anzahl) > 0) {
            // Count um $anzahl verringern
            $_SESSION['warenkorb']['produkte'][$index] = $anzahl;
        } else {
            // Produkt vollständig entfernen
            unset($_SESSION['warenkorb']['produkte'][$index]);
        }
        echo json_encode(["success" => true, "reloadWarenkorb" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Schwerwiegender Fehler: Konnte Produkt Id zum löschen nicht finden!"]);
    }
}

exit;