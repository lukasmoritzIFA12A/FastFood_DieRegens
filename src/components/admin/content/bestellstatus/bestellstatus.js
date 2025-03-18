document.getElementById("bestellstatusForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/bestellstatus/bestellstatus-handler.php", {
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

function deleteBestellstatus(button) {
    let id = button.getAttribute("data-id");
    const formData = new FormData();
    formData.append("delete", "1");
    formData.append("id", id);

    fetch("/FastFood/src/components/admin/content/bestellstatus/bestellstatus-handler.php", {
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
                reloadBestellstatusTabelle();
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

document.getElementById("bestellstatusEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);
    formData.append('update', '1');

    fetch("/FastFood/src/components/admin/content/bestellstatus/bestellstatus-handler.php", {
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
                const modalElement = document.getElementById('bestellstatusModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();

                reloadBestellstatusTabelle();
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

function reloadBestellstatusTabelle() {
    fetch("/FastFood/src/components/admin/content/bestellstatus/bestellstatus-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-orderStatus").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}

function setBestellstatus(jsonString) {
    const bestellstatus = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    document.getElementById("produktid").value = bestellstatus.id;
    document.getElementById("status").value = bestellstatus.status;
    document.getElementById("farbe").value = bestellstatus.farbe;
}