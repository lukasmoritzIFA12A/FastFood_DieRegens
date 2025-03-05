<?php
// Falls keine Werte gesetzt sind, werden Standardwerte genommen (alle sichtbar)
$showCart = $showCart ?? true;
$showLogin = $showLogin ?? true;
$showMenu = $showMenu ?? true;
$menueList = $menueList ?? [];
$produktList = $produktList ?? [];

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user']);
$loginName = '';
if ($isLoggedIn) {
    $loginName = $_SESSION['user'];
}

use App\utils\router;
require_once __DIR__ . '/../../utils/router.php';
?>

<header class="navbar navbar-expand-lg navbar-light bg-light px-3 border-bottom">
    <a class="navbar-brand fs-4" href="<?= router::url('/components/startseite/startseite.php') ?>">MacAPPLE</a>

    <?php if ($showMenu || $showCart || $showLogin): ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
    <?php endif; ?>

    <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <?php if ($showMenu): ?> <!-- Menü nur anzeigen, wenn $showMenu true ist -->
            <ul class="navbar-nav mx-auto"> <!-- zentriert die ersten Elemente -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menusDropdown" role="button" data-bs-toggle="dropdown">Menüs</a>
                    <ul class="dropdown-menu">
                        <?php if (empty($menueList)): ?>
                            <li class="dropdown-item d-flex justify-content-center">-Keine Inhalte-</li>
                        <?php else: ?>
                            <?php foreach ($menueList as $menue): ?>
                                <li class="dropdown-item d-flex justify-content-center">
                                    <a class="nav-link" href="#"><?= $menue->getTitel() ?></a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="burgerDropdown" role="button" data-bs-toggle="dropdown">Burger</a>
                    <ul class="dropdown-menu">
                        <?php if (empty($produktList)): ?>
                            <li class="dropdown-item d-flex justify-content-center">-Keine Inhalte-</li>
                        <?php else: ?>
                            <?php foreach ($produktList as $produkt): ?>
                                <li class="dropdown-item d-flex justify-content-center">
                                    <a class="nav-link" href="#"><?= $produkt->getTitel() ?></a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link" href="<?= router::url('/components/funny-dinner-contest/startseite/startseite.php') ?>">Funny-Dinner-Contest</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= router::url('/components/kontakformular/kontaktformular.php') ?>">Kontakt</a></li>
            </ul>

            <ul class="navbar-nav"> <!-- Für die letzten beiden Elemente, die ganz rechts sein sollen -->
                <?php if ($showCart): ?> <!-- Warenkorb nur anzeigen, wenn $showCart true ist -->
                    <li class="nav-item">
                        <a href="<?= router::url('/components/warenkorb/warenkorb.php') ?>" class="nav-link">
                            <span class="d-flex">
                                <img src="<?= router::url('/../assets/icons/Warenkorb.png') ?>" class="me-1" alt="Warenkorb" width="25" height="25">
                                Warenkorb
                            </span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if ($showLogin): ?> <!-- Login nur anzeigen, wenn $showLogin true ist -->
                    <li class="nav-item">
                        <?php if ($isLoggedIn): ?>
                            <a href="<?= router::url('/components/kundenverwaltung/account/account-fenster.php') ?>" class="nav-link d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-check me-1" viewBox="0 0 16 16">
                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                </svg>
                                <?= $loginName ?>
                            </a>
                        <?php else: ?>
                            <a href="<?= router::url('/components/kundenverwaltung/login/login-fenster.php') ?>" class="nav-link d-flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                </svg>
                                Login
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
</header>
