<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link href="/FastFood/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
</head>
<body>

<?php

use App\components\warenkorb\WarenkorbLogic;
use App\utils\ImageLoader;
use App\utils\JSONParser;
use App\utils\Number;

ob_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../error/error-handler.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$warenkorbEmpty = empty($_SESSION['warenkorb']) || (empty($_SESSION['warenkorb']['menues']) && empty($_SESSION['warenkorb']['produkte']));

if (!isset($_SESSION['user']) || ($warenkorbEmpty)) {
    header('Location: ../startseite/startseite.php');
    exit();
}

$warenkorbLogic = new WarenkorbLogic();
$account = $warenkorbLogic->getEingeloggterKunde($_SESSION['user']);
if (!$account) {
    header('Location: ../startseite/startseite.php');
    exit();
}

$menues = $_SESSION['warenkorb']['menues'] ?? [];
$produkte = $_SESSION['warenkorb']['produkte'] ?? [];

$zahlungsarten = $warenkorbLogic->getAllZahlungsarten();

$warenkorbLogic->updateAllWarenkorb();

$showLogin = true;
$showCart = false;
$showMenu = false;
include '../header/header.php'; // Header einfügen
include 'lieferadresse/lieferadresse-modal.php';
include 'warenkorb-modal.php';
?>

<div class="container mt-5">
    <!-- Header mit App-Name -->
    <h1 class="text-center mb-4">MacAPPLE</h1>

    <form id="warenkorbForm" action="#" method="post">
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
                                type="button"
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
                                   autocomplete="off" data-euro="1.50"
                                <?= $warenkorbLogic->isSelectedTrinkgeld("1.50") ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary rounded-start" for="btn1">1,50€</label>

                            <input type="radio" class="btn-check" name="betrag" id="btn2"
                                   autocomplete="off" data-euro="2.50"
                                <?= $warenkorbLogic->isSelectedTrinkgeld("2.50") ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary" for="btn2">2,50€</label>

                            <input type="radio" class="btn-check" name="betrag" id="btn3"
                                   autocomplete="off" data-euro="3.50"
                                <?= $warenkorbLogic->isSelectedTrinkgeld("3.50") ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary" for="btn3">3,50€</label>

                            <input type="radio" class="btn-check" name="betrag" id="btnAndere"
                                   autocomplete="off" data-euro="Andere"
                                <?= $warenkorbLogic->isSelectedTrinkgeld("Andere") ? 'checked' : '' ?>>
                            <label class="btn btn-outline-primary" for="btnAndere">Andere</label>
                            <input type="text" name="andereBetragInput" id="andereBetragInput" min="0"
                                   class="form-control flex-grow-0"
                                   pattern="^\d+(,\d{1,2})?$"
                                   value="<?= $warenkorbLogic->getAndereTrinkgeld() ?>"
                                <?= $warenkorbLogic->isSelectedTrinkgeld("Andere") ?
                                    "style='width: 12.5%;'" :
                                    "style='width: 12.5%; pointer-events: none; opacity: 0.5; background-color: #ddd;'" ?>>
                        </div>
                    </div>
                </div>

                <!-- Rabattcode -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <label for="rabattcode">Rabattcode</label>
                        </h5>

                        <div class="input-group" id="ohneRabattCodeFeld">
                            <input type="text" id="rabattcode" class="form-control" placeholder="Code"
                                   name="rabattcode">
                            <button id="submitRabatt"
                                    type="button"
                                    class="btn btn-outline-primary rounded-end"
                                    onclick="sendRabattForm()">
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
                            <button class="btn btn-secondary rounded-end"
                                    type="button"
                                    disabled>
                                Einlösen
                            </button>
                        </div>

                        <p id="message" style="color:red;"></p>
                    </div>
                </div>

                <!-- Zahlungsoptionen -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <label>Zahlungsvorgang mit:</label>
                        </h5>
                        <div class="btn-group" role="group" aria-label="Payment options"
                             style="overflow-x: auto; max-width: 85vh; white-space: nowrap;">
                            <?php if (empty($zahlungsarten)): ?>
                                <h5>Keine Zahlungsarten gefunden 😥</h5>
                            <?php else: ?>
                                <?php foreach ($zahlungsarten as $zahlungsart): ?>
                                    <input type="radio" class="btn-check" name="payment"
                                           id="<?= $zahlungsart->getArt() ?>"
                                           autocomplete="off"
                                        <?= $warenkorbLogic->isSelectedZahlungsart($zahlungsart->getId()) ? 'checked' : '' ?>
                                           data-zahlungsmethode="<?= $zahlungsart->getId() ?>" required>
                                    <label class="btn btn-outline-primary"
                                           title="<?= $zahlungsart->getArt() ?>"
                                           for="<?= $zahlungsart->getArt() ?>">
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
                        <div style="max-height: 300px; overflow-y: auto;">
                            <ul class="list-group list-group-flush mb-3">
                                <?php foreach ($menues as $menueId => $count): ?>
                                    <?php
                                    $menue = $warenkorbLogic->getMenueById($menueId);
                                    if (!$menue) {
                                        continue;
                                    }

                                    $gesamtPreis = "0.00";
                                    $preis = Number::unformatPreis($menue->getPreis());
                                    $preis = Number::multiplierPreis($preis, $count);
                                    $gesamtPreis = Number::reformatPreis($preis);
                                    ?>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-grow-1">
                                            <span class="text-truncate" style="white-space: normal;"><?= htmlspecialchars($menue->getTitel()) ?></span>
                                        </div>

                                        <div class="ms-auto me-2" style="flex-shrink: 0;">
                                            <span><?= $gesamtPreis ?> €</span>
                                        </div>

                                        <!-- Counter -->
                                        <div class="input-group" style="width: 12vh; flex-shrink: 0;">
                                            <button class="btn btn-outline-secondary d-flex justify-content-center align-items-center"
                                                    type="button"
                                                    style="height: 3vh;"
                                                    onclick="updateMenuQuantityInWarenkorb(<?= $menueId ?>, <?= $count - 1 ?>)">
                                                -
                                            </button>
                                            <input type="text"
                                                   class="form-control text-center"
                                                   value="<?= $count ?>"
                                                   style="height: 3vh;"
                                                   readonly>
                                            <button class="btn btn-outline-secondary d-flex justify-content-center align-items-center"
                                                    type="button"
                                                    style="height: 3vh;"
                                                    onclick="updateMenuQuantityInWarenkorb(<?= $menueId ?>, <?= $count + 1 ?>)">
                                                +
                                            </button>
                                        </div>
                                    </li>
                                <?php endforeach; ?>

                                <?php foreach ($produkte as $produktId => $count): ?>
                                    <?php
                                    $produkt = $warenkorbLogic->getProduktById($produktId);
                                    if (!$produkt) {
                                        continue;
                                    }

                                    $gesamtPreis = "0.00";
                                    $preis = Number::unformatPreis($produkt->getPreis());
                                    $preis = Number::multiplierPreis($preis, $count);
                                    $gesamtPreis = Number::reformatPreis($preis);
                                    ?>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-grow-1 me-2">
                                            <span class="text-truncate" style="white-space: normal;"><?= htmlspecialchars($produkt->getTitel()) ?></span>
                                        </div>

                                        <div class="ms-auto me-2" style="flex-shrink: 0;">
                                            <span><?= $gesamtPreis ?> €</span>
                                        </div>

                                        <!-- Counter -->
                                        <div class="input-group" style="width: 12vh; flex-shrink: 0;">
                                            <button class="btn btn-outline-secondary d-flex justify-content-center align-items-center"
                                                    type="button"
                                                    style="height: 3vh;"
                                                    onclick="updateProduktQuantityInWarenkorb(<?= $produktId ?>, <?= $count - 1 ?>)">
                                                -
                                            </button>
                                            <input type="text"
                                                   class="form-control text-center"
                                                   value="<?= $count ?>"
                                                   style="height: 3vh;"
                                                   readonly>
                                            <button class="btn btn-outline-secondary d-flex justify-content-center align-items-center"
                                                    type="button"
                                                    style="height: 3vh;"
                                                    onclick="updateProduktQuantityInWarenkorb(<?= $produktId ?>, <?= $count + 1 ?>)">
                                                +
                                            </button>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <p>Rabatt (<?= $warenkorbLogic->getRabattProzent() ?> %): <span class="float-end"
                                         id="rabattEuro"><?= $warenkorbLogic->getRabattSumme() ?> €</span>
                        </p>
                        <p>Zwischensumme: <span class="float-end"><?= $warenkorbLogic->getZwischenSumme() ?> €</span>
                        </p>
                        <p>Trinkgeld: <span class="float-end"
                                            id="trinkgeld"><?= $warenkorbLogic->getTrinkgeldSumme() ?> €</span></p>
                        <hr>
                        <h5>Gesamt: <span class="float-end"><?= $warenkorbLogic->getGesamtSumme() ?> €</span></h5>
                        <button type="submit" class="btn btn-success w-100 mt-3">Bestellen und Bezahlen</button>

                        <p id="bestellMessage" style="color:red;"></p>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="/FastFood/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="warenkorb.js"></script>
    <script src="lieferadresse/lieferadresse.js"></script>
    <script src="rabatt/rabatt.js"></script>
    <script src="trinkgeld/trinkgeld.js"></script>
    <script src="../startseite/produkt/produkt.js"></script>
    <script src="../startseite/menu/menu.js"></script>
    <script src="zahlungsmethode/zahlungsmethode.js"></script>
    <script src="../../utils/session.js"></script>
</body>
</html>
