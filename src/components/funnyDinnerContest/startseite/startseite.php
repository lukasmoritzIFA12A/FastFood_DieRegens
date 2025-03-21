<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funny-Dinner-Contest</title>
    <link href="/FastFood/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="startseite.css" rel="stylesheet">
</head>
<body>
<?php
ob_start();
require_once __DIR__ . '/../../error/error-handler.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';
require_once __DIR__ . '/../../../utils/router.php';

use App\components\funnyDinnerContest\ContestLogic;
use App\utils\router;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$contestLogic = new ContestLogic();

$loggedIn = !empty($_SESSION['user']);

if ($loggedIn) {
    $bestellungen = $contestLogic->getAllBestellungenFromKunde($_SESSION['user']);
} else {
    $bestellungen = [];
}

$showLogin = true;
$showCart = false;
$showMenu = false;
include '../../header/header.php'; // Header einfügen
include 'logged-in-modal.php';
include 'bild-hochgeladen-modal.php';
?>
<div class="container">
    <div class="row funny-dinner-container">
        <div class="col-md-6 instructions">
            <h1>Funny-Dinner-Contest – Dein Essen, Dein Spaß, Dein Gewinn! 🍔📸</h1>
            <p>Hast du schon mal eine Bestellung bekommen, die einfach zu lustig aussah?</p>
            <p>Oder ein Menü, das so kreativ angerichtet war, dass es ein Foto wert ist?</p>
            <p>Dann mach mit beim Funny-Dinner-Contest!</p>
            <p>Lade ein Bild deiner Bestellung hoch, sammle Likes von anderen Usern und gewinne einen 50% Gutschein für
                deine nächste Bestellung!</p>
            <p>Egal, ob kurios angerichtet, überraschend serviert oder einfach nur zum Schmunzeln – hier zählt der
                Spaßfaktor.</p>
            <h2>So geht’s:</h2>
            <ul class="steps">
                <li>📸 Bestellung fotografieren</li>
                <li>⬆️ Bild hochladen</li>
                <li>👍 Bewertungen sammeln</li>
                <li>🏆 Die meisten Votes gewinnen!</li>
            </ul>
        </div>
        <div class="col-md-6 text-center">
            <img src="<?= router::url('/../assets/icons/funny-dinner-Burger.png') ?>" alt="Funny Dinner Image"
                 class="img-fluid">
        </div>
    </div>
    <div class="text-center mt-4">
        <!-- Beide Buttons sind gleich gestylt -->
        <a href="../galerie/galerie.php" class="btn btn-primary btn-lg">Einfach schauen</a>
        <button class="btn btn-success btn-lg" onclick="bildHochladen(<?= $loggedIn ?>)">
            Bild Hochladen
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Wähle deine Bestellung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
            </div>
            <div class="modal-body">

                <div class="order-list-container"
                     style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px;">
                    <?php foreach ($bestellungen as $bestellung): ?>
                        <?php
                        $hint = $contestLogic->getBestellungHint($bestellung);
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="orderOption"
                                   id="<?= $bestellung->getId() ?>"
                                   value="<?= $bestellung->getBestellungDatum() ?>"
                                   onchange="checkSelection()">
                            <label class="form-check-label" for="<?= $bestellung->getId() ?>">
                                vom <?= $bestellung->getBestellungDatum() ?> (<?= $hint ?>)
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <input type="file" id="fileInput" style="display: none;">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-primary mt-3" id="bildAuswahlButton" onclick="bildAuswahl()" disabled>Bild
                        auswählen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/FastFood/assets/bootstrap/js/bootstrap.bundle.js"></script>
<script src="startseite.js"></script>
<script src="../../../utils/session.js"></script>
</body>
</html>
