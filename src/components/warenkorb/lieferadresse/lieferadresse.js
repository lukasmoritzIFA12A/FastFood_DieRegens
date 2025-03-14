document.getElementById("lieferAdresseForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/warenkorb/lieferadresse/lieferadresse-handler.php", {
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
                window.location.href = "../warenkorb/warenkorb.php"; // Weiterleiten
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

function setLieferAdresse(jsonString) {
    const account = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    if (Object.keys(account.adresse).length !== 0) {
        const adresse = account.adresse;
        document.getElementById("newStreet").value = adresse.Strassenname;
        document.getElementById("newNumber").value = adresse.Hausnummer;
        document.getElementById("newPostalCode").value = adresse.PLZ;
        document.getElementById("newCity").value = adresse.Stadt;
        document.getElementById("newZusatz").value = adresse.Zusatz;
    }

    document.getElementById("newVorname").value = account.Vorname
    document.getElementById("newNachname").value = account.Nachname
    document.getElementById("newTelefonnummer").value = account.Telefonnummer
}