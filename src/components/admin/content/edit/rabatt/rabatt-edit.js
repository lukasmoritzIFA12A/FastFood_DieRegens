document.getElementById("rabattEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/edit/rabatt/rabatt-edit-handler.php", {
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
                const modalElement = document.getElementById('rabattModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();

                reloadRabattTabelle();
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

function setRabatt(jsonString) {
    const rabatt = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    document.getElementById("editRabattId").value = rabatt.id;
    document.getElementById("editRabattCode").value = rabatt.code;
    document.getElementById("editRabatt").value = rabatt.minderung;
}