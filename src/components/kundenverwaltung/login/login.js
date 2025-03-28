function togglePassword() {
    const passwordInput = document.getElementById("password"); // Passwortfeld holen

    const passwordIconClosed = document.getElementById("eyeClosed");
    const passwordIconOpened = document.getElementById("eyeOpened");


    // Sichtbarkeit des Passworts umschalten
    if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Zeige das Passwort

        passwordIconClosed.style.display = 'none';
        passwordIconOpened.style.display = '';
    } else {
        passwordInput.type = "password"; // Verstecke das Passwort
        passwordIconClosed.style.display = '';
        passwordIconOpened.style.display = 'none';
    }
}

document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/kundenverwaltung/login/login-handler.php", {
        method: "POST",
        body: formData
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP-Fehler! Status: ${response.status}`);
            }
            return response.json();
        }) // Antwort als JSON
        .then(data => {
            if (data.success) {
                window.location.href = "../../startseite/startseite.php"; // Weiterleiten
            } else {
                if (data.message) {
                    document.getElementById("message").innerText = data.message;
                } else {
                    document.getElementById("message").innerText = "Etwas ist schiefgelaufen!";
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
});