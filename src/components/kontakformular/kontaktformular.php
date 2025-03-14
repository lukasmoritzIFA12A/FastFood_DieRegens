<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontaktformular</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
ob_start();
require_once __DIR__ . '/../error/error-handler.php';
require_once __DIR__ . '/../../../vendor/autoload.php';

$showLogin = true;
$showCart = false;
$showMenu = false;
include '../header/header.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h3 class="text-center">Kontakt</h3>
                <form>
                    <div class="form-group">
                        <label for="username">Nutzenname</label>
                        <input type="text" class="form-control" id="username" placeholder="Nutzenname">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefonnummer</label>
                        <input type="tel" class="form-control" id="phone" placeholder="Telefonnummer">
                    </div>
                    <div class="form-group">
                        <label for="message">Nachricht</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Nachricht"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Abschicken</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../../utils/session.js"></script>
</body>
</html>
