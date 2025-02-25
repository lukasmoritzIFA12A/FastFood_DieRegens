<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registierung - MacAPPLE</title>
    <!-- Einbindung von Bootstrap für schnelle und einfache Gestaltung -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
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
    <div class="container mt-5 flex-grow-1 d-flex flex-column">
        <!-- Hauptüberschrift der Seite -->
        <h1 class="text-center mb-4">Account erstellen</h1>

        <!-- Formular zum Erstellen eines neuen Accounts -->
        <form id="registerForm" action="#" method="POST">
            <!-- Eingabefeld für den Nutzernamen -->
            <div class="mb-3">
                <label for="username" class="form-label">Nutzername</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Nutzername" required>
            </div>

            <!-- Eingabefeld für das Passwort -->
            <div class="mb-3">
                <label for="password" class="form-label">Passwort</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Passwort" required>
            </div>

            <!-- Eingabefeld zur Bestätigung des Passworts -->
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Passwort wiederholen</label>
                <input type="password" id="confirm-password" name="confirm_password" class="form-control"
                       placeholder="Passwort wiederholen" required>
            </div>

            <!-- Eingabefelder für Vor- und Nachname -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="first-name" class="form-label">Vorname</label>
                    <input type="text" id="first-name" name="first_name" class="form-control" placeholder="Vorname" required>
                </div>
                <div class="col-md-6">
                    <label for="last-name" class="form-label">Nachname</label>
                    <input type="text" id="last-name" name="last_name" class="form-control" placeholder="Nachname" required>
                </div>
            </div>

            <!-- Eingabefelder für Telefonnummer, PLZ und Stadt -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="telefon-nummer" class="form-label">Tel. Nummer (Optional)</label>
                    <input type="text" id="telefon-nummer" name="telefon_nummer" class="form-control" placeholder="Tel. Nummer">
                </div>
                <div class="col-md-4">
                    <label for="postleitzahl" class="form-label">PLZ</label>
                    <input type="text" id="postleitzahl" name="postleitzahl" class="form-control" placeholder="PLZ" required>
                </div>
                <div class="col-md-4">
                    <label for="city" class="form-label">Stadt</label>
                    <input type="text" id="city" name="city" class="form-control" placeholder="Stadt" required>
                </div>
            </div>

            <!-- Eingabefelder für Straße und Hausnummer -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="street" class="form-label">Straße</label>
                    <input type="text" id="street" name="street" class="form-control" placeholder="Straße" required>
                </div>
                <div class="col-md-2">
                    <label for="house-number" class="form-label">Haus-Nr.</label>
                    <input type="text" id="house-number" name="house_number" class="form-control" placeholder="Haus-Nr." required>
                </div>
                <div class="col-md-2">
                    <label for="zusatz" class="form-label">Zusatz (Optional)</label>
                    <input type="text" id="zusatz" name="zusatz" class="form-control" placeholder="Zusatz">
                </div>
            </div>

            <!-- Button zum Abschicken des Formulars -->
            <button type="submit" class="btn btn-primary w-100">Account erstellen</button>

            <p id="message" style="color:red;"></p>

            <!-- Link zur Anmeldeseite für bereits registrierte Nutzer -->
            <p class="text-center mt-3">Bereits Mitglied? <a href="<?= router::url('/components/kundenverwaltung/login/login-fenster.php') ?>">Melde dich an!</a></p>
        </form>
    </div>
</body>
<script src="register.js" defer></script>
</html>
