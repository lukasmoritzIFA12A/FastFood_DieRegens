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
$menues = $adminLogic->getAllMenues();
?>

<div class="card shadow">
    <div class="card-header bg-primary text-white text-center">
        <h2 class="mb-0">Menüliste</h2>
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
                    <th class="text-center">Produkte</th>
                    <th class="text-center">Aktion</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($menues as $menue): ?>
                    <tr>
                        <td class="text-center"><?= $menue->getId() ?></td>
                        <td class="text-center">
                            <img src="<?= ImageLoader::getImageHTMLSrc($menue->getBild()); ?>"
                                 alt="Menü Bild"
                                 class="img-thumbnail" width="100" height="100"
                                 onerror="this.src='../../../assets/img/noimage.jpg';">
                        </td>
                        <td class="text-center"><strong><?= $menue->getTitel() ?></strong></td>
                        <td class="text-center text-muted text-wrap" style="max-width: 20vh;">
                            <?= $menue->getBeschreibung() ?>
                        </td>
                        <td class="text-center"><span class="badge bg-success" style="font-size: 0.85rem; padding: 0.5em 0.75em;"><?= $menue->getPreis() ?> €</td>
                        <td class="text-center">
                            <ul class="list-unstyled mb-0">
                                <?php foreach ($menue->getProdukte() as $produkt): ?>
                                    <li><?= $produkt->getTitel() ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-outline-danger delete-btn" data-id="<?= $menue->getId() ?>" onclick="deleteMenue(this)">❌</button>
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal"
                                    data-bs-target="#menueModal"
                                    onclick="setMenue('<?= JSONParser::getJSONEncodedString($menue->jsonSerialize()) ?>')">
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
