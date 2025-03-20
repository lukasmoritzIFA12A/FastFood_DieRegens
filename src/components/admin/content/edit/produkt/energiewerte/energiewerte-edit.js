document.getElementById("editProduktEnergiewerteForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);
    setEnergiewertToSession(formData);
});

function setEnergiewertToSession(formData) {
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
                setEditProduktEnergiewerteAsSet();
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

function setEditProduktEnergiewerteAsSet() {
    setEditButtonForEnergiewerte(true);

    const modalElement = document.getElementById('addEditProduktEnergiewerteModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
    modalInstance.hide();
}

function setEditButtonForEnergiewerte(isSet) {
    if (isSet) {
        document.getElementById('editProduktEnergiewertAdminAddButton').style.display = 'none';
        document.getElementById('editProduktEnergiewertAdminEditButton').style.display = 'inline-flex';
    } else {
        document.getElementById('editProduktEnergiewertAdminAddButton').style.display = 'inline-flex';
        document.getElementById('editProduktEnergiewertAdminEditButton').style.display = 'none';
    }
}