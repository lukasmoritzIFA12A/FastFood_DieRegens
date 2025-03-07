<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php
require_once __DIR__ . '/../error/error-handler.php';
$showMenu = false;
$showCart = false;
include '../header/header.php'; // Header einfügen
?>

<div class="container mt-5">
    <!-- Header mit App-Name -->
    <h1 class="text-center mb-4">MacAPPLE</h1>

    <div class="row">
        <!-- Linke Seite mit den Bestelldetails -->
        <div class="col-md-8">
            <!-- Adresse und persönliche Daten -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Adresse und persönliche Daten</h5>
                    <p class="card-text">Straße ...<br>PLZ & Ort<br>Name<br>Tel. Nummer</p>
                    <a href="#" class="btn btn-outline-primary">Bearbeiten</a>
                </div>
            </div>

            <!-- Lieferzeit -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Lieferzeit</h5>
                    <p class="card-text">Schnellstmöglich 20-30min.</p>
                    <a href="#" class="btn btn-outline-primary">Bearbeiten</a>
                </div>
            </div>

            <!-- Trinkgeld für Fahrer:in -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Fahrer:in Trinkgeld geben?</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary">1,50€</button>
                        <button type="button" class="btn btn-outline-secondary">2,50€</button>
                        <button type="button" class="btn btn-outline-secondary">3,50€</button>
                        <button type="button" class="btn btn-outline-secondary">Andere</button>
                    </div>
                </div>
            </div>

            <!-- Rabattcode -->
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Rabattcode</h5>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Eingabefeld">
                        <button class="btn btn-outline-primary">Einlösen</button>
                    </div>
                </div>
            </div>

            <!-- Zahlungsoptionen -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Zahlungsvorgang mit:</h5>
                    <div class="d-flex flex-wrap">
                        <img src="klarna_logo.png" alt="Klarna" class="me-3" style="height: 40px;">
                        <img src="paypal_logo.png" alt="PayPal" class="me-3" style="height: 40px;">
                        <img src="visa_logo.png" alt="Visa" class="me-3" style="height: 40px;">
                        <img src="mastercard_logo.png" alt="Mastercard" class="me-3" style="height: 40px;">
                        <img src="lastschrift_logo.png" alt="Lastschrift" style="height: 40px;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Rechte Seite mit dem Warenkorb -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Warenkorb</h5>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item">1 Burger <span class="float-end">6,50€</span></li>
                        <li class="list-group-item">2 Salat <span class="float-end">5€</span></li>
                    </ul>
                    <p>Rabatt: <span class="float-end">50%</span></p>
                    <p>Zwischensumme: <span class="float-end">15,80€</span></p>
                    <p>Trinkgeld: <span class="float-end">2,50€</span></p>
                    <hr>
                    <h5>Gesamt: <span class="float-end">16,30€</span></h5>
                    <button class="btn btn-success w-100 mt-3">Bestellen und Bezahlen</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
