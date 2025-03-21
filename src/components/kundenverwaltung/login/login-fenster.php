<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MacAPPLE</title>
    <link href="/FastFood/assets/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="login.css" rel="stylesheet">
</head>
<body>
<?php
ob_start();
require_once __DIR__ . '/../../error/error-handler.php';
require_once __DIR__ . '/../../../../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['user'])) {
    header('Location: ../account/account-fenster.php');
    exit();
}

$showCart = false;
$showLogin = false;
$showMenu = false;
include '../../header/header.php';

use App\utils\router;

require_once __DIR__ . '/../../../utils/router.php';
?>
<div class="d-flex justify-content-center align-items-center bg-light" style="height: 90vh;">
    <div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
        <h2 class="text-center">Login</h2>
        <p class="text-center text-muted">Gib dein Nutzername und Passwort ein</p>
        <form id="loginForm" action="#" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Nutzername</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                        </svg>
                    </span>
                    <input type="text" class="form-control" id="username" placeholder="Nutzername" name="username"
                           required>
                </div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Passwort</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                          <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                        </svg>
                    </span>
                    <input type="password" class="form-control" id="password" placeholder="Passwort" name="password"
                           required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()"
                            style="border-color: #ced4da; color: black">
                        <span id="eyeClosed">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16">
                                <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z"/>
                                <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829"/>
                                <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z"/>
                            </svg>
                        </span>
                       <span id="eyeOpened" style="display: none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                              <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                              <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                            </svg>
                       </span>
                    </button>
                </div>
                <!--UM SIMPEL ZU BLEIBEN, ERSTMAL AUSGEBLENDET-->
                <!--<a href="#" class="text-decoration-none small d-block mt-1 text-end">Passwort vergessen</a>-->
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

        <p id="message" style="color:red;"></p>

        <p class="text-center mt-3">
            Noch kein Mitglied? <a
                    href="<?= router::url('/components/kundenverwaltung/registrierung/register-fenster.php') ?>"
                    class="text-decoration-none">Registrier dich jetzt!</a>
        </p>
    </div>
</div>
</body>
<script src="/FastFood/assets/bootstrap/js/bootstrap.bundle.js"></script>
<script src="login.js" defer></script>
<script src="../../../utils/session.js"></script>
</html>
