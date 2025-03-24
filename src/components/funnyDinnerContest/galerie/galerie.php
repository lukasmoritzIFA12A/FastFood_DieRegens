<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funny-Dinner-Contest - Galerie & Bewertung</title>
    <link href="/FastFood/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="galerie.css" rel="stylesheet">
</head>
<body>
<?php
ob_start();
require_once __DIR__ . '/../../error/error-handler.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\components\funnyDinnerContest\ContestLogic;
use App\utils\ImageLoader;

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$contestLogic = new ContestLogic();

$loggedIn = !empty($_SESSION['user']);
$isAdmin = !empty($_SESSION['admin']);
if ($loggedIn && !$isAdmin) {
    $loggedInKunde = $contestLogic->getKundeByUserName($_SESSION['user']);
} else {
    $loggedInKunde = null;
}

$contests = $contestLogic->getAllContests();

$showLogin = true;
$showCart = false;
$showMenu = false;
include '../../header/header.php';
include 'logged-in-rating-modal.php';
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Funny-Dinner-Contest - Galerie</h1>
    <?php if (empty($contests)): ?>
        <div class="d-flex justify-content-center align-items-center" style="margin-top: 8rem;">
            <div class="text-center">
                <h3>Keine Contests gefunden.😥</h3>
                <br>
                <p>Leider konnten wir keine Contests finden.</p>
                <p>Versuche es später noch einmal oder erstell selber eins!</p>
                <button class="btn btn-primary" onclick="window.location.href='../startseite/startseite.php'">
                    Zurück zur Contest Startseite
                </button>
            </div>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4 mb-4">
            <?php foreach ($contests as $contest): ?>
                <?php
                if ($loggedIn) {
                    $isOwnContest = $loggedInKunde?->getId() === $contest->getBestellung()->getKunde()->getId();
                    $alreadyRated = $contestLogic->hasUserRatedAlreadyOnContest($loggedInKunde, $contest);
                    if ($alreadyRated) {
                        $rating = $contestLogic->getUserRatingFromContest($loggedInKunde, $contest);
                    }
                } else {
                    $isOwnContest = false;
                    $alreadyRated = false;
                    $rating = null;
                }
                ?>

                <?php if ($contest->isFreigeschalten()): ?>
                    <?php if ($alreadyRated): ?>
                        <div class="col">
                            <div class="card d-flex flex-column justify-content-between" style="height: 100%;">
                                <div class="position-absolute top-0 start-0 bg-primary text-white px-3 py-1"
                                 style="border-bottom-right-radius: 10px; border-top-left-radius: 10px;">
                                    <?= $contest->getBestellung()->getKunde()->getLogin()->getNutzername() ?>
                                </div>

                                <img src="<?= ImageLoader::getImageHTMLSrc($contest->getBild()); ?>"
                                     alt="Funny Dinner"
                                     class="card-img-top img-fluid rounded-start mt-2 mx-auto mt-5"
                                     style="object-fit: cover; width: 250px; height: 250px; border-radius: 10px;"
                                     onerror="this.src='../../../assets/img/noimage.jpg';">

                                <div class="card-body text-center">
                                    <div class="alert alert-secondary" role="alert"
                                         style="min-width: 40vh; max-width: 40vh;">
                                        <p class="card-text"><?= $contestLogic->getBestellungHint($contest->getBestellung()) ?></p>
                                    </div>
                                </div>

                                <div class="card-footer text-center bg-white border-0 mb-2">
                                    <div style="color: orange" class="ratedStars mb-2" data-contest-id="<?= $contest->getId() ?>">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                 fill="currentColor"
                                                 class="bi bi-star"
                                                 viewBox="0 0 16 16"
                                                 data-star-id="star<?= $contest->getId() ?>_<?= $i ?>">
                                                <path id="star<?= $contest->getId() ?>_<?= $i ?>Fill" style="display: none"
                                                      d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                <path id="star<?= $contest->getId() ?>_<?= $i ?>Empty"
                                                      d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                    <button class="btn btn-outline-secondary mt-3" disabled>
                                        Bewertet!
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php
                            echo "
                            <script src='galerie-star.js'></script>
                            <script>
                                setStarRating(" . $contest->getId() . ", " . $rating->getRating() . ")
                            </script>";
                        ?>
                    <?php else: ?>
                        <div class="col">
                            <div class="card d-flex flex-column justify-content-between" style="height: 100%;">
                                <div class="position-absolute top-0 start-0 <?= $isOwnContest ? 'bg-warning' : 'bg-primary' ?> text-white px-3 py-1"
                                     style="border-bottom-right-radius: 10px; border-top-left-radius: 10px;">
                                    <?= $contest->getBestellung()->getKunde()->getLogin()->getNutzername() ?>
                                </div>

                                <img src="<?= ImageLoader::getImageHTMLSrc($contest->getBild()); ?>"
                                     alt="Funny Dinner"
                                     class="card-img-top img-fluid rounded-start mt-2 mx-auto mt-5"
                                     style="object-fit: cover; width: 250px; height: 250px; border-radius: 10px;"
                                     onerror="this.src='../../../assets/img/noimage.jpg';">

                                <div class="card-body text-center">
                                    <div class="alert alert-secondary" role="alert"
                                         style="min-width: 40vh; max-width: 40vh;">
                                        <p class="card-text"><?= $contestLogic->getBestellungHint($contest->getBestellung()) ?></p>
                                    </div>
                                </div>

                                <div class="card-footer text-center bg-white border-0 mb-2">
                                    <?php if (!$isOwnContest): ?>
                                        <div class="ratingStars" style="color: orange" class="mb-2" data-contest-id="<?= $contest->getId() ?>">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                     fill="currentColor"
                                                     class="bi bi-star rating-star"
                                                     viewBox="0 0 16 16"
                                                     data-star-id="star<?= $contest->getId() ?>_<?= $i ?>">
                                                    <path id="star<?= $contest->getId() ?>_<?= $i ?>Fill" style="display: none"
                                                          d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                    <path id="star<?= $contest->getId() ?>_<?= $i ?>Empty"
                                                          d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.56.56 0 0 0-.163-.505L1.71 6.745l4.052-.576a.53.53 0 0 0 .393-.288L8 2.223l1.847 3.658a.53.53 0 0 0 .393.288l4.052.575-2.906 2.77a.56.56 0 0 0-.163.506l.694 3.957-3.686-1.894a.5.5 0 0 0-.461 0z"/>
                                                </svg>
                                            <?php endfor; ?>
                                        </div>

                                        <button class="btn btn-outline-primary mt-3" data-contest-id="<?= $contest->getId() ?>" onclick="onBewerten(this, '<?= $loggedInKunde?->getId() ?>')">
                                            Bewerten
                                        </button>
                                 <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($isOwnContest): ?>
                        <div class="col">
                            <div class="card d-flex flex-column justify-content-between" style="height: 100%;">
                                <div class="position-absolute top-0 start-0 bg-secondary text-white px-3 py-1"
                                     style="border-bottom-right-radius: 10px; border-top-left-radius: 10px;">
                                    Wartet auf freischaltung
                                </div>

                                <img src="<?= ImageLoader::getImageHTMLSrc($contest->getBild()); ?>"
                                     alt="Funny Dinner"
                                     class="card-img-top img-fluid rounded-start mt-2 mx-auto mt-5"
                                     style="object-fit: cover; width: 250px; height: 250px; border-radius: 10px; filter: grayscale(100%);"
                                     onerror="this.src='../../../assets/img/noimage.jpg';">

                                <div class="card-body text-center">
                                    <div class="alert alert-secondary" role="alert"
                                         style="min-width: 40vh; max-width: 40vh;">
                                        <p class="card-text"><?= $contestLogic->getBestellungHint($contest->getBestellung()) ?></p>
                                    </div>
                                </div>

                                <div class="card-footer text-center bg-white border-0 mb-2">
                                    <button class="btn btn-outline-secondary mt-3 disabled">
                                        Bewerten
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="/FastFood/assets/bootstrap/js/bootstrap.bundle.js"></script>
<script src="galerie.js"></script>
<script src="../../../utils/session.js"></script>
</body>
</html>
