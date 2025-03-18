<?php
ob_start();
require_once __DIR__ . '/../../../error/error-handler.php';
require_once __DIR__ . '/../../../../../vendor/autoload.php';

use App\components\admin\AdminLogic;
use App\utils\JSONParser;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin'])) {
    header('Location: ../../../startseite/startseite.php');
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
