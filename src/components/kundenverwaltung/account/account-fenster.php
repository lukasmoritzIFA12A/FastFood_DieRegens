<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - MacAPPLE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\components\kundenverwaltung\account\AccountLogic;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: ../../startseite/startseite.php');
    exit();
}

$accountLogic = new AccountLogic();
$account = $accountLogic->getAccountByUsername($_SESSION['user']);
if (!$account) {
    header('Location: ../../startseite/startseite.php');
    exit();
}

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
                <td id="vorname"><?= $account->getVorname() ?></td>
                <td class="d-flex justify-content-end"><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editVorname">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Nachname:</th>
                <td id="nachname"><?= $account->getNachname() ?></td>
                <td class="d-flex justify-content-end"><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editNachname">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Benutzername:</th>
                <td id="benutzername"><?= $account->getLogin()->getNutzername() ?></td>
                <td class="d-flex justify-content-end"><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editBenutzername">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Telefonnummer:</th>
                <td id="telefon"><?= $account->getTelefonnummer() ?></td>
                <td class="d-flex justify-content-end"><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editTelefon">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Adresse:</th>
                <td id="adresse"><?= $accountLogic->getFullAddress($account->getAdresse()) ?></td>
                <td class="d-flex justify-content-end"><button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editAdresse">Bearbeiten</button></td>
            </tr>
            <tr>
                <th>Registrierungsdatum:</th>
                <td id="registrierungsdatum"><?= $account->getRegistrierungsdatum()->format("d.m.Y - H:i"). " Uhr" ?></td>
                <td></td>
            </tr>
        </table>

        <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#orderHistory">Bestellverlauf ansehen</button>
        <button class="btn btn-warning w-100 mt-2" data-bs-toggle="modal" data-bs-target="#changePassword">Passwort ändern</button>
        <button class="btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#logoff">Ausloggen</button>
    </div>
</div>

<!-- Popups für Bearbeitung -->
<div class="modal fade" id="editVorname" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Vorname ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="vornameForm" action="#">
                <div class="modal-body">
                    <input type="text" class="form-control" id="newVorname" name="newVorname" value="<?= htmlspecialchars($account->getVorname()) ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editNachname" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nachname ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="nachnameForm" action="#">
                <div class="modal-body">
                    <input type="text" class="form-control" id="newNachname" name="newNachname" value="<?= htmlspecialchars($account->getNachname()) ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editBenutzername" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Benutzername ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="benutzernameForm" action="#">
                <div class="modal-body">
                    <input type="text" class="form-control" id="newBenutzername" name="newBenutzername" value="<?= htmlspecialchars($account->getLogin()->getNutzername()) ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editTelefon" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Telefonnummer ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="telefonForm" action="#">
                <div class="modal-body">
                    <input type="text" class="form-control" id="newTelefon" name="newTelefon" value="<?= htmlspecialchars($account->getTelefonnummer()) ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Detaillierte Bearbeitung für Adresse -->
<div class="modal fade" id="editAdresse" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adresse bearbeiten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="adresseForm" action="#">
                <div class="modal-body">
                    <div class="d-flex gap-5">
                        <div>
                            <label for="newStreet" class="form-label">Straße</label>
                            <input type="text" class="form-control" id="newStreet" name="newStreet" value=<?= htmlspecialchars($account->getAdresse()->getStrassenname()) ?>>
                        </div>
                        <div>
                            <label for="newNumber" class="form-label">Haus-Nr.</label>
                            <input type="text" class="form-control" id="newNumber" name="newNumber" value=<?= htmlspecialchars($account->getAdresse()->getHausnummer()) ?>>
                        </div>
                    </div>

                    <div class="d-flex gap-5">
                        <div>
                            <label for="newPostalCode" class="form-label mt-2">PLZ</label>
                            <input type="text" class="form-control" id="newPostalCode" name="newPostalCode" value=<?= htmlspecialchars($account->getAdresse()->getPLZ()) ?>>
                        </div>
                        <div>
                            <label for="newCity" class="form-label mt-2">Stadt</label>
                            <input type="text" class="form-control" id="newCity" name="newCity" value=<?= htmlspecialchars($account->getAdresse()->getStadt()) ?>>
                        </div>
                    </div>

                    <div>
                        <label for="newZusatz" class="form-label mt-2">Zusatz</label>
                        <input type="text" class="form-control" id="newZusatz" name="newZusatz" value=<?= htmlspecialchars($account->getAdresse()->getZusatz()) ?>>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="orderHistory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Passwort ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label for="oldPassword" class="form-label">Altes Passwort</label>
                <input type="password" class="form-control mb-2" id="oldPassword" placeholder="Altes Passwort">
                <label for="newPassword" class="form-label">Neues Passwort</label>
                <input type="password" class="form-control" id="newPassword" placeholder="Neues Passwort">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning">Passwort ändern</button>
            </div>
        </div>
    </div>
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="editieren/adresse.js"></script>
<script src="editieren/benutzername.js"></script>
<script src="editieren/nachname.js"></script>
<script src="editieren/telefon.js"></script>
<script src="editieren/vorname.js"></script>
</html>
