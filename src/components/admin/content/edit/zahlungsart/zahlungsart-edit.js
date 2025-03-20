document.getElementById("zahlungsartEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/edit/zahlungsart/zahlungsart-edit-handler.php", {
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

function setZahlungsart(jsonString) {
    const zahlungsart = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    document.getElementById("editZahlungsartId").value = zahlungsart.id;

    setImageAsFile(zahlungsart.bild.bild, "editZahlungsartBild");
    document.getElementById("zahlungsartImageLoaded").src = getImageHTMLSrc(zahlungsart.bild.bild);

    document.getElementById("editZahlungsartArt").value = zahlungsart.Art;
}