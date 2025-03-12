<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php

use App\components\warenkorb\WarenkorbLogic;
use App\utils\ImageLoader;
use App\utils\JSONParser;

ob_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../error/error-handler.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user']) || (empty($_SESSION['produkt']) && empty($_SESSION['menu']))) {
    header('Location: ../startseite/startseite.php');
    exit();
}

$warenkorbLogic = new WarenkorbLogic();
$account = $warenkorbLogic->getEingeloggterKunde($_SESSION['user']);
if (!$account) {
    header('Location: ../startseite/startseite.php');
    exit();
}

$produkte = $warenkorbLogic->getAllProdukteByIds($_SESSION['produkt']);
$menues = $warenkorbLogic->getAllMenuesByIds($_SESSION['menu']);
$zahlungsarten = $warenkorbLogic->getAllZahlungsarten();

$showLogin = true;
$showCart = false;
$showMenu = false;
include '../header/header.php'; // Header einfügen
include 'lieferadresse/lieferadresse-modal.php';
?>

<div class="container mt-5">
    <!-- Header mit App-Name -->
    <h1 class="text-center mb-4">MacAPPLE</h1>

    <div class="row">
        <!-- Linke Seite mit den Bestelldetails -->
        <div class="col-md-8">
            <!-- Lieferadresse -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <label>Lieferadresse</label>
                    </h5>
                    <p class="card-text"><?= $warenkorbLogic->getFormattedLieferAddress($account) ?></p>

                    <button class="btn btn-outline-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#editLieferAdresse"
                            onclick="setLieferAdresse('<?= JSONParser::getJSONEncodedString($account->jsonSerialize()) ?>')">
                        Bearbeiten
                    </button>
                </div>
            </div>

            <!-- Trinkgeld für Fahrer/in -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <label for="andereBetragInput">
                            Fahrer/in Trinkgeld geben?
                        </label>
                    </h5>
                    <div class="input-group" role="group">
                        <input type="radio" class="btn-check" name="betrag" id="btn1"
                               autocomplete="off" data-euro="1,50">
                        <label class="btn btn-outline-primary rounded-start" for="btn1">1,50€</label>

                        <input type="radio" class="btn-check" name="betrag" id="btn2"
                               autocomplete="off" data-euro="2,50">
                        <label class="btn btn-outline-primary" for="btn2">2,50€</label>

                        <input type="radio" class="btn-check" name="betrag" id="btn3"
                               autocomplete="off" data-euro="3,50">
                        <label class="btn btn-outline-primary" for="btn3">3,50€</label>

                        <input type="radio" class="btn-check" name="betrag" id="btnAndere"
                               autocomplete="off" data-euro="Andere">
                        <label class="btn btn-outline-primary" for="btnAndere">Andere</label>
                        <input type="number" name="andereBetragInput" id="andereBetragInput" step="0.01" min="0"
                               class="form-control flex-grow-0"
                               style="width: 12.5%;"
                               disabled>
                    </div>
                </div>
            </div>

            <!-- Rabattcode -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">
                        <label for="rabattcode">Rabattcode</label>
                    </h5>
                    <form id="rabattForm" action="#" method="POST">
                        <div class="input-group" id="ohneRabattCodeFeld">
                            <input type="text" id="rabattcode" class="form-control" placeholder="Code"
                                   name="rabattcode" required>
                            <button type="submit" id="submitRabatt"
                                    class="btn btn-outline-primary rounded-end">
                                Einlösen
                                <span id="checkIcon" class="ms-2 d-none">✓</span>
                            </button>
                        </div>

                        <div class="input-group" id="mitRabattCodeFeld" style="display: none">
                            <div class="card flex-grow-1">
                                <div class="card-body">
                                    <div class="card" style="max-width: 300px;">
                                        <div class="card-body d-flex align-items-center p-2">
                                            <div class="flex-grow-1">
                                                <strong id="rabattcodeAnzeige"></strong>
                                            </div>
                                            <button type="button"
                                                    class="btn-close"
                                                    aria-label="Remove"
                                                    onclick="setRabattInputAsActivated()"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                    class="btn btn-secondary rounded-end"
                                    id="submitRabatt"
                                    disabled>
                                Einlösen
                            </button>
                        </div>

                        <p id="message" style="color:red;"></p>
                    </form>
                </div>
            </div>

            <!-- Zahlungsoptionen -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <label>Zahlungsvorgang mit:</label>
                    </h5>
                    <div class="btn-group" role="group" aria-label="Payment options"
                         style="overflow-x: auto; white-space: nowrap;">
                        <?php if (empty($zahlungsarten)): ?>
                            <h5>Keine Zahlungsarten gefunden 😥</h5>
                        <?php else: ?>
                            <?php foreach ($zahlungsarten as $zahlungsart): ?>
                                <input type="radio" class="btn-check" name="payment" id="<?= $zahlungsart->getArt() ?>"
                                       autocomplete="off"
                                       data-zahlungsmethode="<?= $zahlungsart->getId() ?>">
                                <label class="btn btn-outline-primary" for="<?= $zahlungsart->getArt() ?>">
                                    <img src="<?= ImageLoader::getImageHTMLSrc($zahlungsart->getBild()); ?>"
                                         alt="<?= $zahlungsart->getArt() ?>" style="height: 50px;">
                                </label>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rechte Seite mit dem Warenkorb -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Warenkorb</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <?php foreach ($menues as $menue): ?>
                            <li class="list-group-item"><?= $menue->getTitel() ?> <span
                                        class="float-end"><?= $menue->getPreis() ?> €</span></li>
                        <?php endforeach; ?>

                        <?php foreach ($produkte as $produkt): ?>
                            <li class="list-group-item"><?= $produkt->getTitel() ?> <span
                                        class="float-end"><?= $produkt->getPreis() ?> €</span></li>
                        <?php endforeach; ?>
                    </ul>
                    <p>Rabatt: <span class="float-end" id="rabattEuro">-,-- €</span>
                    </p>
                    <p>Zwischensumme: <span class="float-end">-,-- €</span></p>
                    <p>Trinkgeld: <span class="float-end" id="trinkgeld">-,-- €</span></p>
                    <hr>
                    <h5>Gesamt: <span class="float-end">-,-- €</span></h5>
                    <button class="btn btn-success w-100 mt-3">Bestellen und Bezahlen</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lieferadresse/lieferadresse.js"></script>
    <script src="rabatt/rabatt.js"></script>
    <script src="trinkgeld/trinkgeld.js"></script>
    <script src="zahlungsmethode/zahlungsmethode.js"></script>
    <script src="warenkorb.js"></script>
</body>
</html>
