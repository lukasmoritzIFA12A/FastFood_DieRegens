document.getElementById("energiewerteForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/basic/produkt/energiewerte/energiewerte-handler.php", {
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
                setEnergiewerteAsSet();
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

function setEnergiewerteAsSet() {
    document.getElementById('energiewertAdminAddButton').style.display = 'none';
    document.getElementById('energiewertAdminEditButton').style.display = 'inline-flex';

    const modalElement = document.getElementById('addEnergiewerteModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
    modalInstance.hide();
}