<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Startseite - MacAPPLE</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="startseite.css" rel="stylesheet">
  <!-- Bootstrap JS und jQuery -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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
    <h1>Top Menü</h1>
    <button class="btn btn-primary">Jetzt bestellen</button>
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
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= htmlspecialchars(ImageLoader::getImageHTMLSrc($produkt->getBild())); ?>" alt="Produkt Bild">
                        <div class="card-body">
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
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= ImageLoader::getImageHTMLSrc($menue->getBild()->getBild()); ?>" alt="Menü Bild">
                        <div class="card-body">
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#productModal"
                                    onclick="setProductDetails(
                                            '<?= $menue->getTitel() ?>',
                                            '<?= $menue->getPreis() ?>',
                                            '<?= ImageLoader::getImageHTMLSrc($menue->getBild()->getBild()) ?>',
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
<script>
  // Funktion zum Setzen der Produktdetails im Popup
  function setProductDetails(title, price, imageSrc, description) {
    document.getElementById('productModalLabel').innerText = title;
    document.getElementById('productPrice').innerText = price;
    document.getElementById('productImage').src = imageSrc;
    document.getElementById('productDescription').innerText = description;
  }

  document.getElementById('burgerBtn').addEventListener('click', function() {
      // Burger-Content anzeigen und Menü-Content ausblenden
      document.getElementById('burgerContent').style.display = 'block';
      document.getElementById('menuContent').style.display = 'none';
  });

  document.getElementById('menuBtn').addEventListener('click', function() {
      // Menü-Content anzeigen und Burger-Content ausblenden
      document.getElementById('menuContent').style.display = 'block';
      document.getElementById('burgerContent').style.display = 'none';
  });
</script>
</body>
</html>