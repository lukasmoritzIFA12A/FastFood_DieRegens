<?php
// Falls keine Werte gesetzt sind, werden Standardwerte genommen (alle sichtbar)
if (!isset($showCart)) $showCart = true;
if (!isset($showLogin)) $showLogin = true;
if (!isset($showMenu)) $showMenu = true;
if (!isset($pageTitle)) $pageTitle = "MacAPPLE";

use App\utils\router;
require_once __DIR__ . '/../../utils/router.php';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<header class="navbar navbar-expand-lg navbar-light bg-light px-3 border-bottom">
    <a class="navbar-brand fs-4" href="<?= router::url('/components/startseite/startseite.php') ?>">MacAPPLE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <?php if ($showMenu): ?> <!-- Menü nur anzeigen, wenn $showMenu true ist -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menusDropdown" role="button" data-bs-toggle="dropdown">Menüs</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Menü 1</a></li>
                        <li><a class="dropdown-item" href="#">Menü 2</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="burgerDropdown" role="button" data-bs-toggle="dropdown">Burger</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Burger 1</a></li>
                        <li><a class="dropdown-item" href="#">Burger 2</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="<?= router::url('/components/funny-dinner-contest/startseite/startseite.php') ?>">Funny-Dinner-Contest</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= router::url('/components/kontakformular/kontaktformular.php') ?>">Kontakt</a></li>
            </ul>
        <?php endif; ?>
    </div>

    <div class="d-flex align-items-center">
        <?php if ($showCart): ?> <!-- Warenkorb nur anzeigen, wenn $showCart true ist -->
            <a href="<?= router::url('/components/warenkorb/warenkorb.php') ?>" class="me-3"><img src="<?= router::url('/../assets/icons/Warenkorb.png') ?>" alt="Warenkorb" width="30" height="30"></a>
        <?php endif; ?>

        <?php if ($showLogin): ?> <!-- Login nur anzeigen, wenn $showLogin true ist -->
            <a href="<?= router::url('/components/kundenverwaltung/login/login-fenster.php') ?>" class="text-dark">Login</a>
        <?php endif; ?>
    </div>
</header>
