<?php
ob_start();
require_once __DIR__ . '/../../../../error/error-handler.php';
require_once __DIR__ . '/../../../../../../vendor/autoload.php';

use App\components\admin\AdminLogic;
use App\utils\ImageLoader;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header('Location: ../../../../startseite/startseite.php');
    exit;
}

$adminLogic = new AdminLogic();
$contests = $adminLogic->getAllContests();

?>

<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-0">Contest Bilder Übersicht</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive overflow-auto" style="max-height: 200vh;">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Bild</th>
                    <th class="text-center">Bestellung</th>
                    <th class="text-center">Freigeschaltet</th>
                    <th class="text-center">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($contests as $contest): ?>
                    <tr class="align-middle">
                        <td class="text-center"><?= $contest->getId() ?></td>
                        <td class="text-center">
                            <!-- Bild anzeigen -->
                            <div class="d-flex justify-content-center">
                                <img src="<?= ImageLoader::getImageHTMLSrc($contest->getBild()); ?>"
                                     alt="Contest Bild"
                                     class="img-thumbnail shadow-sm"
                                     width="120"
                                     height="120"
                                     onclick="openContestImage('<?= $contest->getBild()->getBild() ?>');"
                                     onerror="this.src='../../../assets/img/noimage.jpg';">
                            </div>
                        </td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                <!-- Bestellprodukte anzeigen -->
                                <?php foreach ($contest->getBestellung()->getBestellungprodukte() as $produkt): ?>
                                    <li><?= $produkt->getProdukt()->getTitel() ?> (<?= $produkt->getMenge() ?>x)</li>
                                <?php endforeach; ?>
                                <!-- Bestellmenues anzeigen -->
                                <?php foreach ($contest->getBestellung()->getBestellungmenues() as $menue): ?>
                                    <li><?= $menue->getMenue()->getTitel() ?> (<?= $menue->getMenge() ?>x)</li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="text-center">
                            <?php if ($contest->isFreigeschalten()): ?>
                                <div style="color: rgb(40, 167, 69)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                         class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                </div>
                            <?php else: ?>
                                <div style="color: rgb(220, 53, 69)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                         class="bi bi-x-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <!-- Freigeben Button -->
                            <div class="d-flex justify-content-center gap-3">
                                <?php if (!$contest->isFreigeschalten()): ?>
                                    <!-- Freigeben Button -->
                                    <button class="btn btn-success shadow-sm"
                                            onclick="contestFreigeben(<?= $contest->getId() ?>)">
                                        <span>Freigeben</span>
                                    </button>

                                    <!-- Ablehnen Button -->
                                    <button class="btn btn-danger shadow-sm"
                                            onclick="contestAblehnen(<?= $contest->getId() ?>)">
                                        <span>Ablehnen</span>
                                    </button>
                                <?php else: ?>
                                    <!-- Widerrufen Button -->
                                    <button class="btn btn-warning shadow-sm"
                                            onclick="contestWiderrufen(<?= $contest->getId() ?>)">
                                        <span>Widerrufen</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1"
     aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bild anzeigen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center" style="padding: 20px;">
                <img alt="Contest Bild"
                     id="modalContestBild"
                     class="img-fluid shadow-sm"
                     style="max-width: 90%; max-height: 90%; margin: 10px auto;"
                     onerror="this.src='../../../assets/img/noimage.jpg';">
            </div>
        </div>
    </div>
</div>