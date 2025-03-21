<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warenkorb</title>
    <link href="/FastFood/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <style>
        .message-card {
            transition: transform 0.2s;
        }
        .message-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<?php
use App\components\postbox\PostboxLogic;

ob_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../error/error-handler.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: ../startseite/startseite.php');
    exit();
}

$postboxLogic = new PostboxLogic();
$nachrichtenA = $postboxLogic->getNachrichtenFromKunde($_SESSION['user']);

$showLogin = true;
$showCart = false;
$showMenu = false;
include '../header/header.php';
?>

<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">Nachrichten-Postfach</h2>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if (empty($nachrichtenA)) : ?>
            <div class="text-center py-5 empty-state">
                <i class="bi bi-envelope-open display-4 mb-3 d-block"></i>
                <h4 class="fw-normal">Hier ist es etwas leer...</h4>
                <p class="text-muted">Es sieht so aus, als hätten Sie momentan keine Nachrichten.</p>
            </div>
            <?php else: ?>
                <?php foreach ($nachrichtenA as $nachricht): ?>
                    <div class="message-card card <?= !$nachricht->isGelesen() ? 'border-warning' : ''; ?> mb-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small">
                                    <?= $nachricht->getNachrichtDatum(); ?>
                                </span>
                                    <span class="badge <?= $nachricht->isGelesen() ? 'bg-success' : 'bg-warning text-dark'; ?> rounded-pill">
                                    <?= $nachricht->isGelesen() ? 'Gelesen' : 'Ungelesen'; ?>
                                </span>
                            </div>

                            <div class="alert <?= $nachricht->isGelesen() ? 'alert-light' : 'alert-warning'; ?> mb-3 overflow-auto" style="max-height: 15vh;" role="alert">
                                <p class="mb-0"><?= htmlspecialchars($nachricht->getNachricht()); ?></p>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <?php if(!$nachricht->isGelesen()): ?>
                                    <button class="btn btn-primary btn-sm" onclick="nachrichtGelesenMarkieren(<?= $nachricht->getId(); ?>)">
                                        <i class="bi bi-eye me-1"></i>Als gelesen markieren
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-danger btn-sm" onclick="nachrichtLoeschen(<?= $nachricht->getId(); ?>)">
                                    <i class="bi bi-trash me-1"></i>Löschen
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="/FastFood/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="postbox.js"></script>
</body>
</html>