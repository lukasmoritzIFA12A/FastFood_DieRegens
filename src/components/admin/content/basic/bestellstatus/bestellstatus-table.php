<?php
ob_start();
require_once __DIR__ . '/../../../../error/error-handler.php';
require_once __DIR__ . '/../../../../../../vendor/autoload.php';

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
$bestellstatus = $adminLogic->getAllBestellstatus();
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-0">Bestellstatus</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive overflow-auto" style="max-height: 200vh;">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Farbe</th>
                    <th class="text-center">Aktion</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($bestellstatus as $status): ?>
                    <tr>
                        <td class="text-center"><?= $status->getId() ?></td>
                        <td class="text-center"><?= $status->getStatus() ?></td>
                        <td class="text-center" style="background-color: <?= $status->getFarbe() ?>;">
                            <?= $status->getFarbe() ?>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-danger delete-btn" data-id="<?= $status->getId() ?>" onclick="deleteBestellstatus(this)">❌</button>
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                                    data-bs-target="#bestellstatusModal"
                                    onclick="setBestellstatus('<?= JSONParser::getJSONEncodedString($status->jsonSerialize()) ?>')">
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
