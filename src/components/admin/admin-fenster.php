<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php

require_once __DIR__ . '/../error/error-handler.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\components\admin\AdminLogic;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header('Location: ../startseite/startseite.php');
    exit;
}

$adminLogic = new AdminLogic();
$zutaten = $adminLogic->getAllZutaten();
$produkte = $adminLogic->getAllProdukte();

$showCart = false;
$showLogin = false;
$showMenu = false;
include '../header/header.php'; // Header einfügen
?>

<div class="container my-4">
    <div class="mb-4 d-flex">
        <h2>Admin Panel</h2>

        <form action="admin-logoff.php" method="post" class="ms-auto">
            <button class="btn btn-danger" type="submit">
                Ausloggen
            </button>
        </form>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product" type="button" role="tab" aria-controls="product" aria-selected="true">Produkt hinzufügen</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button" role="tab" aria-controls="menu" aria-selected="false">Menü hinzufügen</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="orderStatus-tab" data-bs-toggle="tab" data-bs-target="#orderStatus" type="button" role="tab" aria-controls="orderStatus" aria-selected="false">Bestellstatus hinzufügen</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="nutritionalValues-tab" data-bs-toggle="tab" data-bs-target="#nutritionalValues" type="button" role="tab" aria-controls="nutritionalValues" aria-selected="false">Energiewerte hinzufügen</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="zutat-tab" data-bs-toggle="tab" data-bs-target="#zutat" type="button" role="tab" aria-controls="zutat" aria-selected="false">Zutat hinzufügen</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-3" id="adminTabContent">
        <!-- Produkte hinzufügen -->
        <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
            <h3 class="mb-3">Produkte hinzufügen</h3>
            <form action="#" id="produktForm" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="productImage" class="form-label">Produkt Bild hochladen</label>
                    <input type="file" class="form-control" id="productImage" name="bild" required>
                </div>
                <div class="mb-3">
                    <label for="productTitle" class="form-label">Titel</label>
                    <input type="text" class="form-control" id="productTitle" name="titel" required>
                </div>
                <div class="mb-3">
                    <label for="productDescription" class="form-label">Beschreibung</label>
                    <textarea class="form-control" id="productDescription" name="beschreibung" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="productPrice" class="form-label">Preis</label>
                    <input type="number" step="0.01" class="form-control" id="productPrice" name="preis" required>
                </div>
                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" value="false" id="productStock" name="ausverkauft">
                    <label class="form-check-label" for="productStock">
                        Ausverkauft
                    </label>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Zutaten</label>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addZutatModal" onclick="clearZutatSearchInput()">
                            <i class="bi bi-plus-circle"></i> Hinzufügen
                        </button>
                    </div>
                    <div class="table-responsive scroll-table">
                        <table class="table table-bordered">
                            <tbody id="addedZutatenList">
                            <tr id="noZutatenMessage">
                                <td class="text-center text-muted">Es wurden noch keine Zutaten hinzugefügt.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <input type="hidden" name="zutaten" id="zutatenInput">
                </div>

                <button type="submit" class="btn btn-primary">Produkt hinzufügen</button>
            </form>
        </div>

        <!-- Menü hinzufügen -->
        <div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
            <h3 class="mb-3">Menü hinzufügen</h3>
            <form action="#" id="menueForm" method="post" enctype="multipart/form-data">
                <!-- Menü Bild -->
                <div class="mb-3">
                    <label for="menuImage" class="form-label">Menü Bild hochladen</label>
                    <input type="file" class="form-control" id="menuImage" name="bild" required>
                </div>
                <!-- Menü Titel -->
                <div class="mb-3">
                    <label for="menuTitle" class="form-label">Titel des Menüs</label>
                    <input type="text" class="form-control" id="menuTitle" name="titel" required>
                </div>
                <!-- Menü Beschreibung -->
                <div class="mb-3">
                    <label for="menuDescription" class="form-label">Beschreibung</label>
                    <textarea class="form-control" id="menuDescription" name="beschreibung" rows="3"></textarea>
                </div>
                <!-- Produkte -->
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0">Produkte</label>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal" onclick="clearProductSearchInput()">
                            <i class="bi bi-plus-circle"></i> Hinzufügen
                        </button>
                    </div>
                    <div class="table-responsive scroll-table">
                        <table class="table table-bordered">
                            <tbody id="addedProductsList">
                            <tr id="noProductsMessage">
                                <td class="text-center text-muted">Es wurden noch keine Produkte hinzugefügt.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <input type="hidden" name="produkte" id="produkteInput">
                </div>
                <button type="submit" class="btn btn-primary w-100">Menü hinzufügen</button>
            </form>
        </div>

        <!-- Bestellstatus hinzufügen -->
        <div class="tab-pane fade" id="orderStatus" role="tabpanel" aria-labelledby="orderStatus-tab">
            <h3 class="mb-3">Bestellstatus hinzufügen</h3>
            <form action="#" id="bestellstatusForm" method="post">
                <div class="mb-3">
                    <label for="orderStatus" class="form-label">Status</label>
                    <input type="text" class="form-control" id="orderStatus" name="status" required>
                </div>
                <div class="mb-3">
                    <label for="orderStatusColor" class="form-label">Farbe</label>
                    <input type="color" class="form-control" id="orderStatusColor" name="farbe" required>
                </div>
                <button type="submit" class="btn btn-primary">Bestellstatus hinzufügen</button>
            </form>
        </div>

        <!-- Energiewerte hinzufügen -->
        <div class="tab-pane fade" id="nutritionalValues" role="tabpanel" aria-labelledby="nutritionalValues-tab">
            <h3 class="mb-3">Energiewerte hinzufügen</h3>
            <form action="#" id="energiewerteForm" method="post">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label mb-0" for="energiewertProduct">Produkt</label>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEnergiewertProductModal" onclick="clearEnergiewertProductSearchInput()">
                            <i class="bi bi-plus-circle"></i> Hinzufügen
                        </button>
                    </div>

                    <input type="text" id="energiewertProduct" placeholder="Es wurde kein Produkt ausgewählt." class="form-control" readonly required>
                    <input type="hidden" name="energiewertProdukte" id="energiewertProdukteInput">
                </div>

                <div class="mb-3">
                    <label for="nvPortionSize" class="form-label">Portionsgröße</label>
                    <input type="text" class="form-control" id="nvPortionSize" name="portionSize">
                </div>
                <div class="mb-3">
                    <label for="nvCalories" class="form-label">Kalorien</label>
                    <input type="text" class="form-control" id="nvCalories" name="kalorien">
                </div>
                <div class="mb-3">
                    <label for="nvFat" class="form-label">Fett</label>
                    <input type="text" class="form-control" id="nvFat" name="fett">
                </div>
                <div class="mb-3">
                    <label for="nvCarbohydrates" class="form-label">Kohlenhydrate</label>
                    <input type="text" class="form-control" id="nvCarbohydrates" name="kohlenhydrate">
                </div>
                <div class="mb-3">
                    <label for="nvSugar" class="form-label">Zucker</label>
                    <input type="text" class="form-control" id="nvSugar" name="zucker">
                </div>
                <div class="mb-3">
                    <label for="nvProtein" class="form-label">Eiweiß</label>
                    <input type="text" class="form-control" id="nvProtein" name="eiweiss">
                </div>
                <button type="submit" class="btn btn-primary">Energiewerte hinzufügen</button>
            </form>
        </div>

        <!-- Zutat hinzufügen -->
        <div class="tab-pane fade" id="zutat" role="tabpanel" aria-labelledby="zutat-tab">
            <h3 class="mb-3">Zutat hinzufügen</h3>
            <form action="#" id="zutatForm" method="post">
                <div class="mb-3">
                    <label for="nvZutat" class="form-label">Zutat</label>
                    <input type="text" class="form-control" id="nvZutat" name="zutat">
                </div>

                <button type="submit" class="btn btn-primary">Zutat hinzufügen</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Produktauswahl für Menü hinzufügen -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Produkt hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="productSearch" class="form-control" placeholder="Produkt suchen..." oninput="filterProducts()">
                </div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover" id="productListTable">
                        <tbody id="productList">
                            <?php if (empty($produkte)): ?>
                                <tr>
                                    <td class="text-center text-muted">Es wurden keine Produkte gefunden.</td>
                                </tr>
                            <?php endif;?>

                            <?php foreach ($produkte as $produkt): ?>
                                <tr>
                                    <td class="product-name"><?=$produkt->getTitel()?></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-success btn-sm" onclick="addProductToMenu('<?=$produkt->getTitel()?>', '<?=$produkt->getId()?>')">Hinzufügen</button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Zutatauswahl für Produkt hinzufügen -->
<div class="modal fade" id="addZutatModal" tabindex="-1" aria-labelledby="addZutatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addZutatModalLabel">Zutat hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="zutatSearch" class="form-control" placeholder="Zutat suchen..." oninput="filterZutaten()">
                </div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover" id="zutatListTable">
                        <tbody id="zutatList">
                            <?php if (empty($zutaten)): ?>
                                <tr>
                                    <td class="text-center text-muted">Es wurden keine Zutaten gefunden.</td>
                                </tr>
                            <?php endif;?>

                            <?php foreach ($zutaten as $zutat): ?>
                                <tr>
                                    <td class="zutat-name"><?=$zutat->getZutatName()?></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-success btn-sm" onclick="addZutatToProdukt('<?=$zutat->getZutatName()?>', '<?=$zutat->getId()?>')">Hinzufügen</button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Produktauswahl für Energiewert hinzufügen -->
<div class="modal fade" id="addEnergiewertProductModal" tabindex="-1" aria-labelledby="addEnergiewertProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEnergiewertProductModalLabel">Produkt hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="energiewertProductSearch" class="form-control" placeholder="Produkt suchen..." oninput="filterEnergiewertProduct()">
                </div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover" id="energiewertProductTable">
                        <tbody id="energiewertProductList">
                        <?php if (empty($produkte)): ?>
                            <tr>
                                <td class="text-center text-muted">Es wurden keine Produkte gefunden.</td>
                            </tr>
                        <?php endif;?>

                        <?php foreach ($produkte as $produkt): ?>
                            <tr>
                                <td class="product-name"><?=$produkt->getTitel()?></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-success btn-sm" onclick="addProductToEnergiewert('<?=$produkt->getTitel()?>', '<?=$produkt->getId()?>')">Hinzufügen</button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="content/produkt.js"></script>
<script src="content/menue.js"></script>
<script src="content/bestellstatus.js"></script>
<script src="content/zutat.js"></script>
<script src="content/energiewerte.js"></script>
<script src="admin.js"></script>
</body>
</html>