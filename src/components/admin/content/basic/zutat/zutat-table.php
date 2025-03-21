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
$zutaten = $adminLogic->getAllZutaten();
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-0">Zutaten</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive overflow-auto" style="max-height: 200vh;">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Zutat</th>
                    <th class="text-center">Aktion</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($zutaten as $zutat): ?>
                    <tr>
                        <td class="text-center"><?= $zutat->getId() ?></td>
                        <td class="text-center"><?= $zutat->getZutatName() ?></td>
                        <td class="text-center">
                            <button class="btn btn-outline-danger delete-btn" data-id="<?= $zutat->getId() ?>" onclick="deleteZutat(this)">❌</button>
                            <button class="btn btn-outline-secondary edit-btn"
                                    data-id="<?= $zutat->getId() ?>"
                                    data-name="<?= $zutat->getZutatName() ?>"
                                    data-bs-toggle="modal"
                                    data-bs-target="#zutatModal"
                                    onclick="setZutat('<?= JSONParser::getJSONEncodedString($zutat->jsonSerialize()) ?>')">
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
