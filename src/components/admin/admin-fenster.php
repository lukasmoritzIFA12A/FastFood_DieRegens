<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link href="/FastFood/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php
ob_start();
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

include 'content/bestellstatus/bestellstatus-modal.php';
include 'content/energiewerte/energiewerte-modal.php';
include 'content/menue/menue-modal.php';
include 'content/produkt/produkt-modal.php';
include 'content/rabatt/rabatt-modal.php';
include 'content/zahlungsart/zahlungsart-modal.php';
include 'content/zutat/zutat-modal.php';
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

    <ul class="nav nav-tabs" id="adminMainTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="add-tab" data-bs-toggle="tab" data-bs-target="#add"
                    type="button" role="tab" aria-controls="add" aria-selected="true">Inhalte hinzufügen
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="see-tab" data-bs-toggle="tab" data-bs-target="#see"
                    type="button" role="tab" aria-controls="see" aria-selected="true">Inhalte einsehen
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="unlock-tab" data-bs-toggle="tab" data-bs-target="#unlock"
                    type="button" role="tab" aria-controls="unlock" aria-selected="true">Bilder freischalten
            </button>
        </li>
    </ul>

    <div class="tab-content" id="mainTabsContent">
        <div class="tab-pane fade show active" id="add" role="tabpanel">
            <ul class="nav nav-pills mt-3" id="add" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="product-tab" data-bs-toggle="tab" data-bs-target="#product"
                            type="button" role="tab" aria-controls="product" aria-selected="true">Produkt hinzufügen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="menu-tab" data-bs-toggle="tab" data-bs-target="#menu" type="button" role="tab"
                            aria-controls="menu" aria-selected="false">Menü hinzufügen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="orderStatus-tab" data-bs-toggle="tab" data-bs-target="#orderStatus"
                            type="button" role="tab" aria-controls="orderStatus" aria-selected="false">Bestellstatus hinzufügen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="zutat-tab" data-bs-toggle="tab" data-bs-target="#zutat" type="button"
                            role="tab" aria-controls="zutat" aria-selected="false">Zutat hinzufügen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="zahlungsart-tab" data-bs-toggle="tab" data-bs-target="#zahlungsart"
                            type="button" role="tab" aria-controls="zahlungsart" aria-selected="false">Zahlungsart hinzufügen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="rabatt-tab" data-bs-toggle="tab" data-bs-target="#rabatt"
                            type="button" role="tab" aria-controls="rabatt" aria-selected="false">Rabatt hinzufügen
                    </button>
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
                            <input type="number" step="0.01" min="0" class="form-control" id="productPrice" name="preis"
                                   required>
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
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addZutatModal" onclick="clearZutatSearchInput()" style="display: inline-flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                    Hinzufügen
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

                        <div class="mb-3">
                            <label class="form-label">Energiewerte</label>
                            <br>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addEnergiewerteModal"
                                    id="energiewertAddButton"
                                    style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                                Hinzufügen
                            </button>

                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#addEnergiewerteModal"
                                    id="energiewertEditButton"
                                    style="display: none; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px; margin-bottom: 2.5px" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                </svg>
                                Ändern
                            </button>
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
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addProductModal" onclick="clearProductSearchInput()"
                                        style="display: inline-flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                    </svg>
                                    Hinzufügen
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

                <!-- Zahlungsart hinzufügen -->
                <div class="tab-pane fade" id="zahlungsart" role="tabpanel" aria-labelledby="zahlungsart-tab">
                    <h3 class="mb-3">Zahlungsart hinzufügen</h3>
                    <form action="#" id="zahlungsartForm" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="zahlungsartIcon" class="form-label">Zahlungsart Icon hochladen</label>
                            <input type="file" class="form-control" id="zahlungsartIcon" name="bild" required>
                        </div>
                        <div class="mb-3">
                            <label for="zahlungsartArt" class="form-label">Titel</label>
                            <input type="text" class="form-control" id="zahlungsartArt" name="art" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Zahlungsart hinzufügen</button>
                    </form>
                </div>

                <!-- Rabatt hinzufügen -->
                <div class="tab-pane fade" id="rabatt" role="tabpanel" aria-labelledby="rabatt-tab">
                    <h3 class="mb-3">Rabatt hinzufügen</h3>
                    <form action="#" id="rabattForm" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="rabattCode" class="form-label">Rabatt Code</label>
                            <input type="text" class="form-control" id="rabattCode" name="rabattCode" required>
                        </div>

                        <div class="mb-3">
                            <label for="rabatt" class="form-label">Rabatt (in %)</label>
                            <input type="number" class="form-control" id="rabatt" name="rabatt" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Rabatt hinzufügen</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="see" role="tabpanel">
            <ul class="nav nav-pills mt-3" id="see" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="see-product-tab" data-bs-toggle="tab" data-bs-target="#see-product"
                            type="button" role="tab" aria-controls="see-product" aria-selected="true" onclick="reloadProduktTabelle()">Produkte einsehen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="see-menu-tab" data-bs-toggle="tab" data-bs-target="#see-menu" type="button" role="tab"
                            aria-controls="see-menu" aria-selected="false" onclick="reloadMenueTabelle()">Menüs einsehen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="see-orderStatus-tab" data-bs-toggle="tab" data-bs-target="#see-orderStatus"
                            type="button" role="tab" aria-controls="see-orderStatus" aria-selected="false" onclick="reloadBestellstatusTabelle()">Bestellstatus einsehen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="see-zutat-tab" data-bs-toggle="tab" data-bs-target="#see-zutat" type="button"
                            role="tab" aria-controls="see-zutat" aria-selected="false" onclick="reloadZutatTabelle()">Zutaten einsehen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="see-zahlungsart-tab" data-bs-toggle="tab" data-bs-target="#see-zahlungsart"
                            type="button" role="tab" aria-controls="see-zahlungsart" aria-selected="false" onclick="reloadZahlungsartTabelle()">Zahlungsarten einsehen
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="see-rabatt-tab" data-bs-toggle="tab" data-bs-target="#see-rabatt"
                            type="button" role="tab" aria-controls="see-rabatt" aria-selected="false" onclick="reloadRabattTabelle()">Rabatte einsehen
                    </button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3" id="see-adminTabContent">
                <div class="tab-pane fade show active" id="see-product" role="tabpanel" aria-labelledby="see-product-tab">
                    <?php include 'content/produkt/produkt-table.php'; ?>
                </div>

                <div class="tab-pane fade" id="see-menu" role="tabpanel" aria-labelledby="see-menu-tab">
                </div>

                <div class="tab-pane fade" id="see-orderStatus" role="tabpanel" aria-labelledby="see-orderStatus-tab">
                </div>

                <div class="tab-pane fade" id="see-zutat" role="tabpanel" aria-labelledby="see-zutat-tab">
                </div>

                <div class="tab-pane fade" id="see-zahlungsart" role="tabpanel" aria-labelledby="see-zahlungsart-tab">
                </div>

                <div class="tab-pane fade" id="see-rabatt" role="tabpanel" aria-labelledby="see-rabatt-tab">
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="unlock" role="tabpanel">

        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="/FastFood/assets/bootstrap/js/bootstrap.bundle.js"></script>
<script src="content/produkt/produkt.js"></script>
<script src="content/menue/menue.js"></script>
<script src="content/bestellstatus/bestellstatus.js"></script>
<script src="content/zutat/zutat.js"></script>
<script src="content/energiewerte/energiewerte.js"></script>
<script src="content/zahlungsart/zahlungsart.js"></script>
<script src="content/rabatt/rabatt.js"></script>
<script src="admin.js"></script>
<script src="../../utils/session.js"></script>
<script src="../../utils/imageLoader.js"></script>
</body>
</html>