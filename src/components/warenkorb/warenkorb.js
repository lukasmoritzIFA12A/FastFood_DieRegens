document.getElementById("warenkorbForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    fetch("/FastFood/src/components/warenkorb/warenkorb-handler.php", {
        method: "POST",
        body: null
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP-Fehler! Status: ${response.status}`);
            }
            return response.json();
        }) // Antwort als JSON
        .then(data => {
            if (data.success) {
                document.getElementById("bestellMessage").innerText = "";

                const modal = new bootstrap.Modal(document.getElementById('bestellungErfolgreichModal'));

                document.getElementById('bestellungErfolgreichModal').addEventListener('hidden.bs.modal', function () {
                    window.location.href = "../startseite/startseite.php";
                });

                modal.show();
            } else {
                if (data.message) {
                    document.getElementById("bestellMessage").innerText = data.message;
                } else {
                    document.getElementById("bestellMessage").innerText = "Etwas ist schiefgelaufen!";
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
});

function updateProduktQuantityInWarenkorb(produktId, quantity) {
    sendProductToWarenkorb(produktId.toString(), quantity.toString(), true);
}

function updateMenuQuantityInWarenkorb(menueId, quantity) {
    sendMenuToWarenkorb(menueId.toString(), quantity.toString(), true);
}