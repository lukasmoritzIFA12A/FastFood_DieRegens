<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funny-Dinner-Contest</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="startseite.css" rel="stylesheet">
</head>
<body>
<?php
$pageTitle = "Startseite - MacAPPLE"; // Seitentitel individuell setzen
include '../../header/header.php'; // Header einfügen
use App\utils\router;
require_once __DIR__ . '/../../../utils/router.php';
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
                <li><i class="fas fa-camera"></i> 📸 Bestellung fotografieren</li>
                <li><i class="fas fa-upload"></i> ⬆️ Bild hochladen</li>
                <li><i class="fas fa-thumbs-up"></i> 👍 Bewertungen sammeln</li>
                <li><i class="fas fa-trophy"></i> 🏆 Die meisten Votes gewinnen!</li>
            </ul>
        </div>
        <div class="col-md-6 text-center">
            <img src="<?= router::url('/../assets/icons/funny-dinner-Burger.png') ?>" alt="Funny Dinner Image" class="img-fluid">
        </div>
    </div>
    <div class="text-center mt-4">
        <!-- Beide Buttons sind gleich gestylt -->
        <a href="../galerie/galerie.php" class="btn btn-primary btn-lg">Einfach schauen</a>
        <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#uploadModal">Bild Hochladen</button>
    </div>

    <!-- Zur Startseite Button -->
    <div class="text-center mt-3">
        <a href="../../startseite/startseite.php" class="btn btn-info btn-lg">Zur Startseite</a> <!-- Button führt zurück zur Startseite -->
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
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="orderOption" id="order1" value="16.02.25">
                    <label class="form-check-label" for="order1">
                        vom 16.02.25 (Schweine Burger, Menü 1, Cola, ...)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="orderOption" id="order2" value="03.01.25">
                    <label class="form-check-label" for="order2">
                        vom 03.01.25 (Schweine Burger, Menü 1, Cola, ...)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="orderOption" id="order3" value="18.03.24">
                    <label class="form-check-label" for="order3">
                        vom 18.03.24 (Schweine Burger, Menü 1, Cola, ...)
                    </label>
                </div>

                <!-- Hier kannst du weitere Bestellungen hinzufügen -->
                <button class="btn btn-primary mt-3">Bild auswählen</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
