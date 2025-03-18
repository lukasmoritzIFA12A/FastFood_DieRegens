document.getElementById("produktForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/produkt/produkt-handler.php", {
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

document.getElementById("produktEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);
    formData.append('update', '1');

    fetch("/FastFood/src/components/admin/content/produkt/produkt-handler.php", {
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
                const modalElement = document.getElementById('produktModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();

                reloadProduktTabelle();
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

function deleteProdukt(button) {
    let id = button.getAttribute("data-id");
    const formData = new FormData();
    formData.append("delete", "1");
    formData.append("id", id);

    fetch("/FastFood/src/components/admin/content/produkt/produkt-handler.php", {
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
                reloadProduktTabelle();
            } else {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Etwas ist schiefgelaufen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}

function reloadProduktTabelle() {
    fetch("/FastFood/src/components/admin/content/produkt/produkt-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-product").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}

function setProdukt(jsonString) {
    const produkt = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    document.getElementById("newStreet").value = adresse.Strassenname;
    document.getElementById("newNumber").value = adresse.Hausnummer;
    document.getElementById("newPostalCode").value = adresse.PLZ;
    document.getElementById("newCity").value = adresse.Stadt;
    document.getElementById("newZusatz").value = adresse.Zusatz;
}