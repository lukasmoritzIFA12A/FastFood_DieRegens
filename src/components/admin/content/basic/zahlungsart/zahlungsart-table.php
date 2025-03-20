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
$zahlungsarten = $adminLogic->getAllZahlungsarten();
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-0">Zahlungsarten</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive overflow-auto" style="max-height: 200vh;">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Art</th>
                    <th class="text-center">Bild</th>
                    <th class="text-center">Aktion</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($zahlungsarten as $zahlungsart): ?>
                    <tr>
                        <td class="text-center"><?= $zahlungsart->getId() ?></td>
                        <td class="text-center"><?= $zahlungsart->getArt() ?></td>
                        <td class="text-center">
                            <img src="<?= ImageLoader::getImageHTMLSrc($zahlungsart->getBild()); ?>"
                                 alt="Zahlungsart Bild"
                                 class="img-thumbnail" width="50" height="50"
                                 onerror="this.src='../../../assets/img/noimage.jpg';">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-danger delete-btn" data-id="<?= $zahlungsart->getId() ?>" onclick="deleteZahlungsart(this)">❌</button>
                            <button class="btn btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#zahlungsartModal"
                                    onclick="setZahlungsart('<?= JSONParser::getJSONEncodedString($zahlungsart->jsonSerialize()) ?>')">
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
