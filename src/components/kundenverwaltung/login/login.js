function togglePassword() {
    const passwordInput = document.getElementById("password"); // Passwortfeld holen
    const passwordIcon = document.getElementById("passwordIcon"); // Icon im Button holen

    // Sichtbarkeit des Passworts umschalten
    if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Zeige das Passwort
        passwordIcon.classList.remove("bi-eye-slash"); // Wechsle das Icon
        passwordIcon.classList.add("bi-eye");
    } else {
        passwordInput.type = "password"; // Verstecke das Passwort
        passwordIcon.classList.remove("bi-eye"); // Wechsle das Icon zurück
        passwordIcon.classList.add("bi-eye-slash");
    }
}

document.getElementById("loginForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/controller/login-handler.php", {
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
                window.location.href = "dashboard.php"; // Weiterleiten
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