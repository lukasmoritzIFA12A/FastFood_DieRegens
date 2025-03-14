document.querySelectorAll('input[name="payment"]').forEach((radio) => {
    radio.addEventListener('change', () => {
        updateZahlungsmethode();
    });
});

function updateZahlungsmethode() {
    const radios = document.querySelectorAll('input[name="payment"]');
    radios.forEach(radio => {
        if (radio.checked) {
            const zahlungsMethodeValue = radio.getAttribute('data-zahlungsmethode');
            sendZahlungsmethodeToSession(zahlungsMethodeValue);
        }
    });
}

function sendZahlungsmethodeToSession(zahlungsmethode) {
    const formData = new FormData();
    formData.append("zahlungsmethode", zahlungsmethode);

    fetch("/FastFood/src/components/warenkorb/zahlungsmethode/zahlungsmethode-handler.php", {
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
            if (!data.success) {
                alert("Schwerwiegender Fehler: Konnte Trinkgeld nicht setzen!");
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}