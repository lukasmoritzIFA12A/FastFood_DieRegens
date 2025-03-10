<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funny-Dinner-Contest - Galerie & Bewertung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="galerie.css" rel="stylesheet">
</head>
<body>
<?php
require_once __DIR__ . '/../../error/error-handler.php';

$showLogin = true;
$showCart = false;
$showMenu = false;
include '../../header/header.php';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Funny-Dinner-Contest - Galerie</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- Bild 1 -->
        <div class="col">
            <div class="card h-100">
                <img src="path-to-image1.jpg" class="card-img-top" alt="Funny Dinner 1">
                <div class="card-body">
                    <h5 class="card-title">Bild 1 - Burger mit Smiley</h5>
                    <p class="card-text">Burger, Cola...</p>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rateModal">
                        Bewerten
                    </button>
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#orderModal"
                            onclick="setOrderDetails('Burger, Cola...')">Bestellen
                    </button>
                </div>
            </div>
        </div>
        <!-- Beispielbilder 2 bis 10 -->
        <div class="col">
            <div class="card h-100">
                <img src="path-to-image2.jpg" class="card-img-top" alt="Funny Dinner 2">
                <div class="card-body">
                    <h5 class="card-title">Bild 2 - Pizza mit Smiley</h5>
                    <p class="card-text">Pizza, Fanta...</p>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rateModal">
                        Bewerten
                    </button>
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#orderModal"
                            onclick="setOrderDetails('Pizza, Fanta...')">Bestellen
                    </button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="path-to-image3.jpg" class="card-img-top" alt="Funny Dinner 3">
                <div class="card-body">
                    <h5 class="card-title">Bild 3 - Pommes Tower</h5>
                    <p class="card-text">Pommes, Sprite...</p>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rateModal">
                        Bewerten
                    </button>
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#orderModal"
                            onclick="setOrderDetails('Pommes, Sprite...')">Bestellen
                    </button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="path-to-image4.jpg" class="card-img-top" alt="Funny Dinner 4">
                <div class="card-body">
                    <h5 class="card-title">Bild 4 - Döner mit Herz</h5>
                    <p class="card-text">Döner, Ayran...</p>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rateModal">
                        Bewerten
                    </button>
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#orderModal"
                            onclick="setOrderDetails('Döner, Ayran...')">Bestellen
                    </button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="path-to-image5.jpg" class="card-img-top" alt="Funny Dinner 5">
                <div class="card-body">
                    <h5 class="card-title">Bild 5 - Sushi Lachgesicht</h5>
                    <p class="card-text">Sushi, Grüner Tee...</p>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rateModal">
                        Bewerten
                    </button>
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#orderModal"
                            onclick="setOrderDetails('Sushi, Grüner Tee...')">Bestellen
                    </button>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100">
                <img src="path-to-image6.jpg" class="card-img-top" alt="Funny Dinner 6">
                <div class="card-body">
                    <h5 class="card-title">Bild 6 - Taco-Spaß</h5>
                    <p class="card-text">Taco, Margarita...</p>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rateModal">
                        Bewerten
                    </button>
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#orderModal"
                            onclick="setOrderDetails('Taco, Margarita...')">Bestellen
                    </button>
                </div>
            </div>
        </div>
        <!-- Bild 1 -->
        <div class="col">
            <div class="card h-100">
                <img src="path-to-image.jpg" class="card-img-top" alt="Funny Dinner 1">
                <div class="card-body">
                    <h5 class="card-title">Bild 1 - Burger mit Smiley</h5>
                    <p class="card-text">Burger, Cola...</p>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rateModal">
                        Bewerten
                    </button>
                    <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#orderModal"
                            onclick="setOrderDetails('Burger, Cola...')">Bestellen
                    </button>
                </div>
            </div>
        </div>

        <!-- Weitere Bilder können hier hinzugefügt werden -->
    </div>

    <!-- Modal für die Bewertung -->
    <div class="modal fade" id="rateModal" tabindex="-1" aria-labelledby="rateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rateModalLabel">Bewertung abgeben</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <p>Wie findest du dieses Bild?</p>
                    <div class="d-flex justify-content-center rating">
                        <i class="fa fa-star" data-rating="1"></i>
                        <i class="fa fa-star" data-rating="2"></i>
                        <i class="fa fa-star" data-rating="3"></i>
                        <i class="fa fa-star" data-rating="4"></i>
                        <i class="fa fa-star" data-rating="5"></i>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary w-100">Bewertung absenden</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal für Bestellung -->
    <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalLabel">Bestellung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Ausgewählte Produkte:</strong></p>
                    <p id="orderDetails">-</p>
                    <div class="mt-3">
                        <button class="btn btn-success w-100">Zum Warenkorb hinzufügen</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="galerie.js"></script>
</body>
</html>
