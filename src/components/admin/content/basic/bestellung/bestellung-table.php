<?php
ob_start();
require_once __DIR__ . '/../../../../error/error-handler.php';
require_once __DIR__ . '/../../../../../../vendor/autoload.php';

use App\components\admin\AdminLogic;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header('Location: ../../../../startseite/startseite.php');
    exit;
}

$adminLogic = new AdminLogic();
$bestellungen = $adminLogic->getAllBestellungen();
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-0">Bestellungen</h2>
    </div>
    <div class="card-body">
       <div class="table-responsive overflow-auto" style="max-height: 200vh;">
             <table id="bestellTabelle" class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Bestelldatum</th>
                    <th class="text-center">Kunde</th>
                    <th class="text-center">Zahlungsart</th>
                    <th class="text-center">Produkte</th>
                    <th class="text-center">Menüs</th>
                    <th class="text-center">Trinkgeld</th>
                    <th class="text-center">Rabatt</th>
                    <th class="text-center">Bestellstatus</th>
                    <th class="text-center">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($bestellungen as $bestellung): ?>
                    <tr>
                        <td class="text-center"><?= $bestellung->getId() ?></td>
                        <td class="text-center"><?= $bestellung->getBestellungDatum() ?></td>
                        <td class="text-center"><?= $bestellung->getKunde()->getId() ?> - <?= $bestellung->getKunde()->getNachname() ?></td>
                        <td class="text-center"><?= $bestellung->getZahlungsart()?->getArt() ?? 'Bestellt' ?></td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($bestellung->getBestellungprodukte() as $produkt): ?>
                                    <li><?= $produkt->getProdukt()->getTitel() ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($bestellung->getBestellungmenues() as $menue): ?>
                                    <li><?= $menue->getMenue()->getTitel() ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="text-center"><?= $bestellung->getTrinkgeld() ?? '' ?></td>
                        <td class="text-center"><?= $bestellung->getRabatt() ? $bestellung->getRabatt()->getCode() : '' ?></td>
                        <td class="text-center">
                            <select class="form-select form-select-sm" onchange="updateBestellstatus(<?= $bestellung->getId() ?>, this.value)">
                                <option value="inBearbeitung" <?= $bestellung->getBestellstatus() == 'inBearbeitung' ? 'selected' : '' ?>>In Bearbeitung</option>
                                <option value="versandt" <?= $bestellung->getBestellstatus() == 'versandt' ? 'selected' : '' ?>>Versandt</option>
                                <option value="zugestellt" <?= $bestellung->getBestellstatus() == 'zugestellt' ? 'selected' : '' ?>>Zugestellt</option>
                                <option value="storniert" <?= $bestellung->getBestellstatus() == 'storniert' ? 'selected' : '' ?>>Storniert</option>
                            </select>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-danger delete-btn" data-id="<?= $bestellung->getId() ?>" onclick="deleteBestellung(this)">❌</button>
                            <button class="btn btn-outline-secondary" onclick="editBestellung(<?= $bestellung->getId() ?>)">✏️</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>