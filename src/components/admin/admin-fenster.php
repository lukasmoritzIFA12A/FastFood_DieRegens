<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel</title>
    <link href="/FastFood/assets/datatables/datatables.min.css" rel="stylesheet">
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

include 'content/edit/bestellstatus/bestellstatus-edit-modal.php';
include 'content/basic/produkt/energiewerte/energiewerte-modal.php';
include 'content/edit/menue/menue-edit-modal.php';
include 'content/add/menue/menue-add-modal.php';
include 'content/edit/produkt/produkt-edit-modal.php';
include 'content/add/produkt/produkt-add-modal.php';
include 'content/edit/rabatt/rabatt-edit-modal.php';
include 'content/edit/zahlungsart/zahlungsart-edit-modal.php';
include 'content/edit/zutat/zutat-edit-modal.php';
?>

<div class="container my-4">
    <div class="mb-4 d-flex">
        <h2>Admin Panel</h2>

        <form action="admin-delete-cookies.php" method="post" class="ms-auto">
            <button class="btn btn-warning" type="submit">
                Cookies löschen
            </button>
        </form>

        <form action="admin-logoff.php" method="post" class="ms-2">
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
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="order-tab" data-bs-toggle="tab" data-bs-target="#order"
                    type="button" role="tab" aria-controls="order" aria-selected="true">Bestellungen einsehen
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
                <?php include 'content/add/produkt/produkt-add.php'; ?>

                <!-- Menü hinzufügen -->
                <?php include 'content/add/menue/menue-add.php'; ?>

                <!-- Bestellstatus hinzufügen -->
                <?php include 'content/add/bestellstatus/bestellstatus-add.php'; ?>

                <!-- Zutat hinzufügen -->
                <?php include 'content/add/zutat/zutat-add.php'; ?>

                <!-- Zahlungsart hinzufügen -->
                <?php include 'content/add/zahlungsart/zahlungsart-add.php'; ?>

                <!-- Rabatt hinzufügen -->
                <?php include 'content/add/rabatt/rabatt-add.php'; ?>
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
                    <?php include 'content/basic/produkt/produkt-table.php'; ?>
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

        <div class="tab-pane fade" id="order" role="tabpanel">
            <?php include 'content/basic/bestellung/bestellung-table.php'; ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="/FastFood/assets/jquery-3.7.1.min.js"></script>
<script src="/FastFood/assets/bootstrap/js/bootstrap.bundle.js"></script>
<script src="/FastFood/assets/datatables/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#bestellTabelle').DataTable({
            "order": [[0, 'desc']],
            "paging": false,
            "searching": false,
            "info": false,
            "lengthChange": false,
            "columnDefs": [
                { "orderable": false, "targets": [-1] }
            ]
        });
    });
</script>

<script src="content/basic/produkt/produkt.js"></script>
<script src="content/add/produkt/produkt-add.js"></script>
<script src="content/delete/produkt/produkt-delete.js"></script>
<script src="content/edit/produkt/produkt-edit.js"></script>

<script src="content/basic/menue/menue.js"></script>
<script src="content/add/menue/menue-add.js"></script>
<script src="content/delete/menue/menue-delete.js"></script>
<script src="content/edit/menue/menue-edit.js"></script>

<script src="content/basic/bestellstatus/bestellstatus.js"></script>
<script src="content/add/bestellstatus/bestellstatus-add.js"></script>
<script src="content/delete/bestellstatus/bestellstatus-delete.js"></script>
<script src="content/edit/bestellstatus/bestellstatus-edit.js"></script>

<script src="content/basic/zutat/zutat.js"></script>
<script src="content/add/zutat/zutat-add.js"></script>
<script src="content/delete/zutat/zutat-delete.js"></script>
<script src="content/edit/zutat/zutat-edit.js"></script>

<script src="content/basic/produkt/energiewerte/energiewerte.js"></script>
<script src="content/add/produkt/energiewerte/energiewerte-add.js"></script>
<script src="content/edit/produkt/energiewerte/energiewerte-edit.js"></script>

<script src="content/basic/zahlungsart/zahlungsart.js"></script>
<script src="content/add/zahlungsart/zahlungsart-add.js"></script>
<script src="content/delete/zahlungsart/zahlungsart-delete.js"></script>
<script src="content/edit/zahlungsart/zahlungsart-edit.js"></script>

<script src="content/basic/rabatt/rabatt.js"></script>
<script src="content/add/rabatt/rabatt-add.js"></script>
<script src="content/delete/rabatt/rabatt-delete.js"></script>
<script src="content/edit/rabatt/rabatt-edit.js"></script>

<script src="admin.js"></script>
<script src="../../utils/session.js"></script>
<script src="../../utils/imageLoader.js"></script>
</body>
</html>