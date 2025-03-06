<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
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

/*if (!isset($_SESSION['admin'])) {
    header('Location: ../../startseite/startseite.php');
    exit();
}*/

$adminLogic = new AdminLogic();
$zutaten = $adminLogic->getAllZutaten();

$showCart = false;
$showLogin = false;
$showMenu = false;
include '../header/header.php'; // Header einfügen
?>

<div class="container my-4">
    <h2 class="mb-4">Admin Panel</h2>
    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product" type="button" role="tab" aria-controls="product" aria-selected="true">Produkte hinzufügen</button>
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
                <div class="mb-3">
                    <label for="productStock" class="form-label">Lagerbestand</label>
                    <input type="number" class="form-control" id="productStock" name="lagerbestand" required>
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
            <form action="#" method="post">
                <div class="mb-3">
                    <label for="nvProduct" class="form-label">Produkt auswählen</label>
                    <select class="form-select" id="nvProduct" name="produkt" required>
                        <!-- Dynamisch aus der Datenbank laden -->
                        <option value="1">Produkt 1</option>
                        <option value="2">Produkt 2</option>
                    </select>
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
                        <!-- Beispielprodukte; in der Praxis dynamisch laden -->
                        <tr>
                            <td class="product-name">Hamburger</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-success btn-sm" onclick="addProductToMenu('Hamburger')">Hinzufügen</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="product-name">Pommes</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-success btn-sm" onclick="addProductToMenu('Pommes')">Hinzufügen</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="product-name">Salat</td>
                            <td class="text-end">
                                <button type="button" class="btn btn-success btn-sm" onclick="addProductToMenu('Salat')">Hinzufügen</button>
                            </td>
                        </tr>
                        <!-- Weitere Produkte -->
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
                                    <button type="button" class="btn btn-success btn-sm" onclick="addZutatToProdukt('<?=$zutat->getZutatName()?>')">Hinzufügen</button>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="content/produkt.js"></script>
<script src="content/menue.js"></script>
<script src="content/bestellstatus.js"></script>
<script src="admin.js"></script>
</body>
</html>