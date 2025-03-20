<?php
ob_start();
require_once __DIR__ . '/../../../../error/error-handler.php';
require_once __DIR__ . '/../../../../../../vendor/autoload.php';

use App\utils\ImageLoader;
use App\components\admin\AdminLogic;
use App\utils\JSONParser;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header('Location: ../../../../startseite/startseite.php');
    exit;
}

$adminLogic = new AdminLogic();
$produkte = $adminLogic->getAllProdukte();
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-0">Produktliste</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive overflow-auto" style="max-height: 200vh;">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Bild</th>
                    <th class="text-center">Titel</th>
                    <th class="text-center">Beschreibung</th>
                    <th class="text-center">Preis</th>
                    <th class="text-center">Energiewerte</th>
                    <th class="text-center">Zutaten</th>
                    <th class="text-center">Verfügbar</th>
                    <th class="text-center">Aktion</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($produkte as $produkt): ?>
                    <tr>
                        <td class="text-center"><?= $produkt->getId() ?></td>
                        <td class="text-center">
                            <img src="<?= ImageLoader::getImageHTMLSrc($produkt->getBild()); ?>"
                                 alt="Produkt Bild"
                                 class="img-thumbnail" width="100" height="100"
                                 onerror="this.src='../../../assets/img/noimage.jpg';">
                        </td>
                        <td class="text-center"><strong><?= $produkt->getTitel() ?></strong></td>
                        <td class="text-center text-muted text-wrap" style="max-width: 20vh;">
                            <?= $produkt->getBeschreibung() ?>
                        </td>
                        <td class="text-center"><span class="badge bg-success" style="font-size: 0.85rem; padding: 0.5em 0.75em;"><?= $produkt->getPreis() ?> €</td>
                        <td class="text-center">
                            <?php if($produkt->getEnergiewert()): ?>
                                <span class="d-block">Portion: <?= $produkt->getEnergiewert()->getPortionSize() ?></span>
                                <span class="d-block">Kalorien: <?= $produkt->getEnergiewert()->getKalorien() ?>kcal</span>
                                <span class="d-block">Fett: <?= $produkt->getEnergiewert()->getFett() ?>g</span>
                                <span class="d-block">KH: <?= $produkt->getEnergiewert()->getKohlenhydrate() ?>g</span>
                                <span class="d-block">Zucker: <?= $produkt->getEnergiewert()->getZucker() ?>g</span>
                                <span class="d-block">Eiweiß: <?= $produkt->getEnergiewert()->getEiweiss() ?>g</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($produkt->getZutat() as $zutat): ?>
                                    <li><?= $zutat->getZutatName() ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="text-center">
                            <?php if($produkt->isAusverkauft()): ?>
                                <div style="color: rgb(220, 53, 69)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                    </svg>
                                </div>
                            <?php else: ?>
                                <div style="color: rgb(40, 167, 69)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-danger delete-btn" data-id="<?= $produkt->getId() ?>" onclick="deleteProdukt(this)">❌</button>
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                                    data-bs-target="#produktModal"
                                    onclick="setProdukt('<?= JSONParser::getJSONEncodedString($produkt->jsonSerialize()) ?>')">
                                ✏️
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>