<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/FastFood/assets/js/login.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/FastFood/assets/css/login.css" rel="stylesheet">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
<div class="card p-4 shadow-lg" style="max-width: 400px; width: 100%;">
    <h2 class="text-center">Login</h2>
    <p class="text-center text-muted">Gib dein Nutzername und Passwort ein</p>

    <form id="loginForm" action="#" method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Nutzername</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                <input type="text" class="form-control" id="username" placeholder="Nutzername" name="username" required>
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Passwort</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" class="form-control" id="password" placeholder="Passwort" name="password" required>
                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()"
                        style="border-color: #ced4da;">
                    <i id="passwordIcon" class="bi bi-eye-slash" style="color: black"></i>
                </button>
            </div>
            <a href="#" class="text-decoration-none small d-block mt-1 text-end">Passwort vergessen</a>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>

    <p id="message" style="color:red;"></p>

    <p class="text-center mt-3">
        Noch kein Mitglied? <a href="register-fenster.html" class="text-decoration-none">Registrier dich jetzt!</a>
    </p>
</div>
</body>
</html>
