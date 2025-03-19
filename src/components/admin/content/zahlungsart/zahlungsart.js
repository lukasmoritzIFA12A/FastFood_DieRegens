document.getElementById("zahlungsartForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/zahlungsart/zahlungsart-handler.php", {
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

document.getElementById("zahlungsartEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);
    formData.append('update', '1');

    fetch("/FastFood/src/components/admin/content/zahlungsart/zahlungsart-handler.php", {
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
                const modalElement = document.getElementById('zahlungsartModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();

                reloadZahlungsartTabelle();
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

function deleteZahlungsart(button) {
    let id = button.getAttribute("data-id");
    const formData = new FormData();
    formData.append("delete", "1");
    formData.append("id", id);

    fetch("/FastFood/src/components/admin/content/zahlungsart/zahlungsart-handler.php", {
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
                reloadZahlungsartTabelle();
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

function reloadZahlungsartTabelle() {
    fetch("/FastFood/src/components/admin/content/zahlungsart/zahlungsart-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-zahlungsart").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}

function setZahlungsart(jsonString) {
    const zahlungsart = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    document.getElementById("editZahlungsartId").value = zahlungsart.id;

    setImageAsFile(zahlungsart.bild.bild, "editZahlungsartBild");
    document.getElementById("zahlungsartImageLoaded").src = getImageHTMLSrc(zahlungsart.bild.bild);

    document.getElementById("editZahlungsartArt").value = zahlungsart.Art;
}