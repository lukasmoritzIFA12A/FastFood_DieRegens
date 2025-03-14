<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account - MacAPPLE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="account.css">
</head>
<body>
<?php
ob_start();
require_once __DIR__ . '/../../error/error-handler.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\kundenverwaltung\account\AccountLogic;
use App\utils\JSONParser;

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

$bestellungen = $accountLogic->getBestellungen($_SESSION['user']);

$showCart = false;
$showLogin = false;
$showMenu = false;
include '../../header/header.php'; // Header einfügen
include 'editieren/adresse/adresse-modal.php';
include 'editieren/benutzername/benutzername-modal.php';
include 'editieren/nachname/nachname-modal.php';
include 'editieren/passwort/passwort-modal.php';
include 'editieren/telefon/telefon-modal.php';
include 'editieren/vorname/vorname-modal.php';
include 'bestellungen-modal.php';
?>
<div class="container mt-5">
    <h2 class="text-center">Account verwalten</h2>
    <div class="card p-4">
        <table class="table">
            <tr>
                <th>Vorname:</th>
                <td id="vorname"><?= $account->getVorname() ?></td>
                <td class="d-flex justify-content-end">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editVorname"
                            onclick="setVorname()">Bearbeiten
                    </button>
                </td>
            </tr>
            <tr>
                <th>Nachname:</th>
                <td id="nachname"><?= $account->getNachname() ?></td>
                <td class="d-flex justify-content-end">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editNachname"
                            onclick="setNachname()">Bearbeiten
                    </button>
                </td>
            </tr>
            <tr>
                <th>Benutzername:</th>
                <td id="benutzername"><?= $account->getLogin()->getNutzername() ?></td>
                <td class="d-flex justify-content-end">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editBenutzername"
                            onclick="setBenutzername()">Bearbeiten
                    </button>
                </td>
            </tr>
            <tr>
                <th>Telefonnummer:</th>
                <td id="telefon"><?= $account->getTelefonnummer() ?></td>
                <td class="d-flex justify-content-end">
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editTelefon"
                            onclick="setTelefon()">Bearbeiten
                    </button>
                </td>
            </tr>
            <tr>
                <th>Adresse:</th>
                <td id="adresse"><?= $accountLogic->getFullAddress($account->getAdresse()) ?></td>
                <td class="d-flex justify-content-end">
                    <button class="btn btn-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#editAdresse"
                            onclick="setAdresse('<?= JSONParser::getJSONEncodedString($account->getAdresse()->jsonSerialize()) ?>')">
                        Bearbeiten
                    </button>
                </td>
            </tr>
            <tr>
                <th>Registrierungsdatum:</th>
                <td id="registrierungsdatum"><?= $account->getRegistrierungsdatum() . " Uhr" ?></td>
                <td></td>
            </tr>
        </table>

        <button class="btn btn-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#orderHistory">Bestellverlauf
            ansehen
        </button>
        <button class="btn btn-warning w-100 mt-2" data-bs-toggle="modal" data-bs-target="#changePassword">Passwort
            ändern
        </button>

        <form action="editieren/logoff.php" method="post">
            <button class="btn btn-danger w-100 mt-2" data-bs-toggle="modal" data-bs-target="#logoff">Ausloggen</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="editieren/adresse/adresse.js"></script>
<script src="editieren/benutzername/benutzername.js"></script>
<script src="editieren/nachname/nachname.js"></script>
<script src="editieren/telefon/telefon.js"></script>
<script src="editieren/vorname/vorname.js"></script>
<script src="editieren/passwort/passwort.js"></script>
<script src="../../../utils/session.js"></script>
</body>
</html>
