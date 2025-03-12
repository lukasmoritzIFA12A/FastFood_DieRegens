document.getElementById("energiewerteForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    const selectBox = document.getElementById("energiewertProduct");
    if (selectBox.hasAttribute("readonly")) {
        selectBox.removeAttribute("readonly");
        let isValid = this.reportValidity();

        selectBox.setAttribute("readonly", "true");
        if (!isValid) {
            alert("Produkt muss ausgewählt werden!");
            return;
        }
    }

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/energiewerte/energiewerte-handler.php", {
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
                window.location.href = "../admin/admin-fenster.php"; // Weiterleiten
            } else {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Etwas ist schiefgelaufen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
});