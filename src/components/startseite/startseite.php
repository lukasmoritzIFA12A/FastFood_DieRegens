<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Startseite - MacAPPLE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="startseite.css" rel="stylesheet">
</head>
<body>
<?php
require_once __DIR__ . '/../error/error-handler.php';
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\components\startseite\StartseiteLogic;
use App\utils\router;
use App\utils\ImageLoader;

$startSeiteLogik = new StartseiteLogic();
$produktList = $startSeiteLogik->getProduktList();
$menueList = $startSeiteLogik->getMenueList();

include '../header/header.php'; // Header einfügen
require_once __DIR__ . '/../../utils/router.php';
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
              <div class="card mx-auto shadow-lg border-0 d-flex flex-row align-items-center" style="max-width: 1000px;">
                  <!-- Bild-Seite -->
                  <div class="col-md-4 p-0">
                      <img src="<?= ImageLoader::getImageHTMLSrc($topMenue->getBild()); ?>"
                           alt="Top Menü Bild"
                           class="img-fluid rounded-start"
                           style="object-fit: cover; width: 100%; height: 100%;">
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
                          <button class="btn btn-primary btn-lg">Jetzt bestellen</button>
                      </div>
                  </div>
              </div>
          <?php else: ?>
              <div class="text-center">
                  <p class="text-muted fs-5">Derzeit ist kein Top Menü verfügbar. Probieren Sie unsere anderen Highlights aus!</p>
              </div>
          <?php endif; ?>
      </div>
  </div>

    <!-- Categories Section -->
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center gap-3">
            <!-- Button für Burger -->
            <button class="btn btn-outline-primary" id="burgerBtn">
                <img src="<?= router::url('/../assets/icons/Burger_Icon.png') ?>" alt="Burger" style="width: 50px;">
                <p>Burger</p>
            </button>

            <!-- Button für Menü -->
            <button class="btn btn-outline-primary" id="menuBtn">
                <img src="<?= router::url('/../assets/icons/Menu_Icon.png') ?>" alt="Menü" style="width: 50px;">
                <p>Menüs</p>
            </button>
        </div>
    </div>

    <div id="burgerContent" class="content">
        <div class="product-scroll">
            <div class="row">
                <?php if (empty($produktList)): ?>
                    <div class="col-12 text-center">
                        <i class="bi bi-cart-x" style="font-size: 50px; margin-bottom: 20px;"></i>
                        <h3>Keine Produkte gefunden.😥</h3>
                        <br>
                        <p>Leider konnten wir keine Produkte finden.</p>
                        <p>Versuche es später noch einmal oder schau dir unsere anderen Angebote an!</p>
                    </div>
                <?php endif; ?>

                <?php foreach ($produktList as $produkt): ?>
                    <div class="col-md-2 mb-4">
                        <div class="card">
                            <img src="<?= ImageLoader::getImageHTMLSrc($produkt->getBild()); ?>"
                                 alt="Produkt Bild"
                                 style="width: 250px; height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <p class="text-center"><?= $produkt->getTitel() ?> - <?= $produkt->getPreis() ?> €</p>
                                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#productModal"
                                        onclick="setProductDetails(
                                                '<?= $produkt->getTitel() ?>',
                                                '<?= $produkt->getPreis() ?>',
                                                '<?= ImageLoader::getImageHTMLSrc($produkt->getBild()) ?>',
                                                '<?= $produkt->getBeschreibung() ?>')">
                                    Jetzt bestellen
                                </button>
                            </div>
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
                        <i class="bi bi-cart-x" style="font-size: 50px; margin-bottom: 20px;"></i>
                        <h3>Keine Menüs gefunden.😥</h3>
                        <br>
                        <p>Leider konnten wir keine Menüs finden.</p>
                        <p>Versuche es später noch einmal oder schau dir unsere anderen Angebote an!</p>
                    </div>
                <?php endif; ?>

                <?php foreach ($menueList as $menue): ?>
                    <div class="col-md-2 mb-4">
                        <div class="card">
                            <img src="<?= ImageLoader::getImageHTMLSrc($menue->getBild()); ?>"
                                 alt="Menü Bild"
                                 style="width: 250px; height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <p class="text-center"><?= $menue->getTitel() ?> - <?= $menue->getPreis() ?> €</p>
                                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#productModal"
                                        onclick="setProductDetails(
                                                '<?= $menue->getTitel() ?>',
                                                '<?= $menue->getPreis() ?>',
                                                '<?= ImageLoader::getImageHTMLSrc($menue->getBild()) ?>',
                                                '<?= $menue->getBeschreibung() ?>')">
                                    Jetzt bestellen
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Modal (Produkt Popup) -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="productModalLabel">Produkt Titel</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <img id="productImage" class="img-fluid" alt="Produkt Bild">
              </div>
              <div class="col-md-6">
                <p><strong>Preis:</strong> <span id="productPrice"></span></p>
                <p><strong>Produktbeschreibung:</strong></p>
                <p id="productDescription"></p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            <button type="button" class="btn btn-primary">In den Warenkorb</button>
          </div>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="startseite.js"></script>
</body>
</html>