<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account verwalten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
$pageTitle = "Account - MacAPPLE"; // Seitentitel individuell setzen
$showCart = false;
$showLogin = false;
$showMenu = false;
include '../../header/header.php'; // Header einfügen
?>
<div class="container mt-5">
    <h2 class="text-center">Account verwalten</h2>
    <div class="card p-4">
        <table class="table">
            <tr>
                <th>Vorname:</th>
                <td id="vorname">Max</td>
                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editVorname">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Nachname:</th>
                <td id="nachname">Mustermann</td>
                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editNachname">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Benutzername:</th>
                <td id="benutzername">MaxMuster</td>
                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editBenutzername">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Telefonnummer:</th>
                <td id="telefon">+49 123 456789</td>
                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editTelefon">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Adresse:</th>
                <td id="adresse">Musterstraße 1, 12345 Musterstadt</td>
                <td><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editAdresse">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Registrierungsdatum:</th>
                <td id="registrierungsdatum">01.01.2024</td>
                <td></td>
            </tr>
        </table>
        <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#orderHistory">Bestellverlauf ansehen</button>
        <button class="btn btn-warning w-100 mt-2" data-bs-toggle="modal" data-bs-target="#changePassword">Passwort ändern</button>
    </div>
</div>

<!-- Popups für Bearbeitung -->
<div class="modal fade" id="editVorname" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vorname ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="newVorname" value="Max">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editNachname" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nachname ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="newNachname" value="Mustermann">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editBenutzername" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Benutzername ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="newBenutzername" value="MaxMuster">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTelefon" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Telefonnummer ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" id="newTelefon" value="+49 123 456789">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>

<!-- Detaillierte Bearbeitung für Adresse -->
<div class="modal fade" id="editAdresse" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adresse bearbeiten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="newStreet" class="form-label">Straße</label>
                <input type="text" class="form-control" id="newStreet" value="Musterstraße 1">
                <label for="newPostalCode" class="form-label mt-2">PLZ</label>
                <input type="text" class="form-control" id="newPostalCode" value="12345">
                <label for="newCity" class="form-label mt-2">Stadt</label>
                <input type="text" class="form-control" id="newCity" value="Musterstadt">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="orderHistory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bestellverlauf</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Hier werden vergangene Bestellungen angezeigt.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changePassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Passwort ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="password" class="form-control mb-2" placeholder="Altes Passwort">
                <input type="password" class="form-control" placeholder="Neues Passwort">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning">Passwort ändern</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
