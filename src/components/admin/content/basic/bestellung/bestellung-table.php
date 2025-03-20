<?php
ob_start();
require_once __DIR__ . '/../../../../error/error-handler.php';
require_once __DIR__ . '/../../../../../../vendor/autoload.php';

use App\components\admin\AdminLogic;
use App\utils\Number;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header('Location: ../../../../startseite/startseite.php');
    exit;
}

$adminLogic = new AdminLogic();
$bestellungen = $adminLogic->getAllBestellungen();
$bestellstatuse = $adminLogic->getAllBestellstatus();
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
                    <th class="text-center">Bestellung</th>
                    <th class="text-center">Trinkgeld</th>
                    <th class="text-center">Rabatt</th>
                    <th class="text-center">Preis</th>
                    <th class="text-center">Bestellstatus</th>
                    <th class="text-center">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bestellungen as $bestellung): ?>
                    <tr>
                        <td class="text-center"><?= $bestellung->getId() ?></td>
                        <td class="text-center"><?= $bestellung->getBestellungDatum() ?></td>
                        <td class="text-center"><?= $bestellung->getKunde()->getId() ?>
                            - <?= $bestellung->getKunde()->getNachname() ?></td>
                        <td class="text-center"><?= $bestellung->getZahlungsart()?->getArt() ?? 'Bestellt' ?></td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($bestellung->getBestellungprodukte() as $produkt): ?>
                                    <li><?= $produkt->getProdukt()->getTitel() ?> (<?= $produkt->getMenge() ?>x)
                                    </li>
                                <?php endforeach; ?>
                                <?php foreach ($bestellung->getBestellungmenues() as $menue): ?>
                                    <li><?= $menue->getMenue()->getTitel() ?> (<?= $menue->getMenge() ?>x)</li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <?php if (empty($bestellung->getTrinkgeld())): ?>
                            <td class="text-center"></td>
                        <?php else: ?>
                            <td class="text-center"><?= Number::reformatPreis($bestellung->getTrinkgeld()) ?> €</td>
                        <?php endif; ?>

                        <td class="text-center"><?= $bestellung->getRabatt() ? $bestellung->getRabatt()->getCode() : '' ?></td>

                        <td class="text-center"><?= $bestellung->getPreis() . ' €' ?? '' ?></td>

                        <td class="text-center">
                            <select class="form-select form-select-sm"
                                    id="selectBestellstatus"
                                    onchange="onSelectChange('<?= $bestellung->getId() ?>', this.value)">
                                <?php if (empty($bestellung->getBestellstatus())): ?>
                                    <option value="" style="color: #6c757d" selected disabled>Bitte wählen...</option>
                                <?php endif; ?>

                                <?php foreach ($bestellstatuse as $bestellstatus): ?>
                                    <option value="<?= $bestellstatus->getId() ?>" <?= $bestellung->getBestellstatus()?->getStatus() === $bestellstatus->getStatus() ? 'selected' : '' ?>>
                                        <?= $bestellstatus->getStatus() ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-danger delete-btn" data-id="<?= $bestellung->getId() ?>"
                                    onclick="deleteBestellung(this)">❌
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>