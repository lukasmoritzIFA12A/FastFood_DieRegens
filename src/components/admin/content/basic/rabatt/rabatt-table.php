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
$rabatte = $adminLogic->getAllRabatte();
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-0">Rabatte</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive overflow-auto" style="max-height: 200vh;">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-primary">
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Rabatt Code</th>
                    <th class="text-center">Rabatt (in %)</th>
                    <th class="text-center">Aktion</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($rabatte as $rabatt): ?>
                    <tr>
                        <td class="text-center"><?= $rabatt->getId() ?></td>
                        <td class="text-center"><?= $rabatt->getCode() ?></td>
                        <td class="text-center"><?= $rabatt->getMinderung() ?></td>
                        <td class="text-center">
                            <button class="btn btn-outline-danger delete-btn" data-id="<?= $rabatt->getId() ?>" onclick="deleteRabatt(this)">❌</button>
                            <button class="btn btn-outline-secondary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#rabattModal"
                                    onclick="setRabatt('<?= JSONParser::getJSONEncodedString($rabatt->jsonSerialize()) ?>')">
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
