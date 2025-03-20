<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startseite - MacAPPLE</title>
    <link href="/FastFood/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="startseite.css" rel="stylesheet">
</head>
<body>
<?php
ob_start();
require_once __DIR__ . '/../error/error-handler.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\components\startseite\StartseiteLogic;
use App\utils\ImageLoader;
use App\utils\JSONParser;
use App\utils\router;

$startSeiteLogik = new StartseiteLogic();
$produktList = $startSeiteLogik->getProduktList();
$menueList = $startSeiteLogik->getMenueList();

$showLogin = true;
$showCart = true;
$showMenu = true;
include '../header/header.php'; // Header einfügen
require_once __DIR__ . '/../../utils/router.php';

include 'menu/menu-modal.php';
include 'produkt/produkt-modal.php';
include 'logged-in-modal.php';
?>

<!-- Main Content -->
<div class="container mt-4">
    <div class="text-center mb-4">
        <div class="container mt-5 mb-5">
            <div class="text-center">
                <h1 class="mb-4 fw-bold display-4 text-primary">Unser Top Menü</h1>
            </div>

            <?php
            $topMenue = $startSeiteLogik->getTopMenue();
            if ($topMenue): // Prüfen, ob ein Menü vorhanden ist
                ?>
                <div class="card mx-auto shadow-lg border-0 d-flex flex-row align-items-center"
                     style="max-width: 1000px;">
                    <!-- Bild-Seite -->
                    <div class="col-md-4 p-0">
                        <img src="<?= ImageLoader::getImageHTMLSrc($topMenue->getBild()); ?>"
                             alt="Top Menü Bild"
                             class="img-fluid rounded-start"
                             style="object-fit: cover; width: 250px; height: 250px; border-radius: 10px;"
                             onerror="this.src='../../../assets/img/noimage.jpg';">
                    </div>

                    <!-- Text-Seite -->
                    <div class="col-md-8 d-flex align-items-center">
                        <div class="card-body">
                            <h2 class="card-title display-6 fw-bold"><?= htmlspecialchars($topMenue->getTitel()); ?></h2>
                            <p class="card-text text-muted mb-4"><?= htmlspecialchars($topMenue->getBeschreibung()); ?></p>
                            <p class="card-text">
                                <strong class="fs-3 text-success">
                                    <?= $topMenue->getPreis() ?> €
                                </strong>
                            </p>
                            <button class="btn btn-primary btn-lg"
                                    style="width: 250px;"
                                    data-bs-toggle="modal" data-bs-target="#menuModal"
                                    onclick="setMenueDetails('<?= JSONParser::getJSONEncodedString($topMenue->jsonSerialize()) ?>')">
                                Jetzt bestellen
                            </button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center">
                    <p class="text-muted fs-5">Derzeit ist kein Top Menü verfügbar. Probieren Sie unsere anderen
                        Highlights aus!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center gap-3">
            <!-- Button für Produkte -->
            <button class="btn btn-outline-primary" id="burgerBtn">
                <img src="<?= router::url('/../assets/icons/Burger_Icon.png') ?>" alt="Produkte" style="width: 7vh;">
                <p>Produkte</p>
            </button>

            <!-- Button für Menü -->
            <button class="btn btn-outline-primary" id="menuBtn">
                <img src="<?= router::url('/../assets/icons/Menu_Icon.png') ?>" alt="Menü" style="width: 7vh;">
                <p>Menüs</p>
            </button>
        </div>
    </div>

    <div id="burgerContent" class="content">
        <div class="product-scroll">
            <div class="row">
                <?php if (empty($produktList)): ?>
                    <div class="col-12 text-center">
                        <h3>Keine Produkte gefunden.😥</h3>
                        <br>
                        <p>Leider konnten wir keine Produkte finden.</p>
                        <p>Versuche es später noch einmal oder schau dir unsere anderen Angebote an!</p>
                    </div>
                <?php endif; ?>

                <?php foreach ($produktList as $produkt): ?>
                    <div class="col-md-2 mb-4">
                        <div class="card align-items-center" style="height: 40vh;">
                            <?php if ($produkt->isAusverkauft()): ?>
                                <img src="<?= ImageLoader::getImageHTMLSrc($produkt->getBild()); ?>"
                                     alt="Produkt Bild"
                                     class="mt-2"
                                     style="width: 25vh; max-height: 19vh; min-height: 19vh; object-fit: cover; border-radius: 1vh; filter: grayscale(100%);"
                                     onerror="this.src='../../../assets/img/noimage.jpg';">
                                <div class="card-body text-center d-flex flex-column"
                                     style="min-height: 20vh; max-height: 20vh;">
                                    <div>
                                        <h5 class="mb-2" style="color: #888"><?= $produkt->getTitel() ?></h5>
                                        <p class="fw-bold text-secondary fs-4"><s><?= $produkt->getPreis() ?> €</s></p>
                                    </div>
                                    <div class="mt-auto">
                                        <button class="btn btn-secondary" style="width: 25vh;" disabled>
                                            AUSVERKAUFT!
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <img src="<?= ImageLoader::getImageHTMLSrc($produkt->getBild()); ?>"
                                     alt="Produkt Bild"
                                     class="mt-2"
                                     style="width: 25vh; max-height: 19vh; min-height: 19vh; object-fit: cover; border-radius: 1vh;"
                                     onerror="this.src='../../../assets/img/noimage.jpg';">
                                <div class="card-body text-center d-flex flex-column"
                                     style="min-height: 20vh; max-height: 20vh;">
                                    <div>
                                        <h5 class="mb-2"><?= $produkt->getTitel() ?></h5>
                                        <p class="fw-bold text-success fs-4"><?= $produkt->getPreis() ?> €</p>
                                    </div>
                                    <div class="mt-auto">
                                        <button class="btn btn-primary"
                                                style="width: 25vh;"
                                                data-bs-toggle="modal" data-bs-target="#productModal"
                                                onclick="setProductDetails('<?= JSONParser::getJSONEncodedString($produkt->jsonSerialize()) ?>')">
                                            Jetzt bestellen
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div id="menuContent" class="content" style="display:none;">
        <div class="product-scroll">
            <div class="row">
                <?php if (empty($menueList)): ?>
                    <div class="col-12 text-center">
                        <h3>Keine Menüs gefunden.😥</h3>
                        <br>
                        <p>Leider konnten wir keine Menüs finden.</p>
                        <p>Versuche es später noch einmal oder schau dir unsere anderen Angebote an!</p>
                    </div>
                <?php endif; ?>

                <?php foreach ($menueList as $menue): ?>
                    <div class="col-md-2 mb-4">
                        <div class="card align-items-center" style="height: 40vh;">

                            <?php if ($menue->isAusverkauft()): ?>
                                <img src="<?= ImageLoader::getImageHTMLSrc($menue->getBild()); ?>"
                                     alt="Menü Bild"
                                     class="mt-2"
                                     style="width: 25vh; max-height: 20vh; min-height: 20vh; object-fit: cover; border-radius: 1vh; filter: grayscale(100%);"
                                     onerror="this.src='../../../assets/img/noimage.jpg';">
                                <div class="card-body text-center d-flex flex-column">
                                    <div>
                                        <h5 class="mb-2" style="color: #888"><?= $menue->getTitel() ?></h5>
                                        <p class="fw-bold text-secondary fs-4"><s><?= $menue->getPreis() ?> €</s></p>
                                    </div>
                                    <div class="mt-auto">
                                        <button class="btn btn-secondary" style="width: 25vh;" disabled>
                                            AUSVERKAUFT!
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <img src="<?= ImageLoader::getImageHTMLSrc($menue->getBild()); ?>"
                                     alt="Menü Bild"
                                     class="mt-2"
                                     style="width: 25vh; max-height: 20vh; min-height: 20vh; object-fit: cover; border-radius: 1vh;"
                                     onerror="this.src='../../../assets/img/noimage.jpg';">
                                <div class="card-body text-center d-flex flex-column">
                                    <div>
                                        <h5 class="mb-2"><?= $menue->getTitel() ?></h5>
                                        <p class="fw-bold text-success fs-4"><?= $menue->getPreis() ?> €</p>
                                    </div>
                                    <div class="mt-auto">
                                        <button class="btn btn-primary"
                                                style="width: 25vh;"
                                                data-bs-toggle="modal" data-bs-target="#menuModal"
                                                onclick="setMenueDetails('<?= JSONParser::getJSONEncodedString($menue->jsonSerialize()) ?>')">
                                            Jetzt bestellen
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script src="/FastFood/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="startseite.js"></script>
<script src="menu/menu.js"></script>
<script src="produkt/produkt.js"></script>
<script src="../../utils/imageLoader.js"></script>
<script src="../../utils/session.js"></script>
</body>
</html>