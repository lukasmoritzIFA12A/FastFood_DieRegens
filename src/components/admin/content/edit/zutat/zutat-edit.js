document.getElementById("zutatEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);
    formData.append('update', '1');

    fetch("/FastFood/src/components/admin/content/edit/zutat/zutat-edit-handler.php", {
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
                const modalElement = document.getElementById('zutatModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();

                reloadZutatTabelle();
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

function setZutat(jsonString) {
    const zutat = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    document.getElementById("zutatid").value = zutat.id;
    document.getElementById("zutatName").value = zutat.ZutatName;
}