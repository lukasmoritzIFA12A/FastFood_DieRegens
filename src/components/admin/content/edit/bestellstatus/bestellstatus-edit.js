document.getElementById("bestellstatusEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/edit/bestellstatus/bestellstatus-edit-handler.php", {
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

function setBestellstatus(jsonString) {
    const bestellstatus = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    document.getElementById("produktid").value = bestellstatus.id;
    document.getElementById("status").value = bestellstatus.status;
    document.getElementById("farbe").value = bestellstatus.farbe;
}