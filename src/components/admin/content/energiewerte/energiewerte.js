document.getElementById("energiewerteForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/energiewerte/energiewerte-handler.php", {
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

document.getElementById("editProduktEnergiewerteForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(this);
    setEnergiewertToSession(formData);
});

function setEnergiewertToSession(formData) {
    fetch("/FastFood/src/components/admin/content/energiewerte/energiewerte-handler.php", {
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

function setEnergiewerteAsSet() {
    document.getElementById('energiewertAdminAddButton').style.display = 'none';
    document.getElementById('energiewertAdminEditButton').style.display = 'inline-flex';

    const modalElement = document.getElementById('addEnergiewerteModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
    modalInstance.hide();
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

function setEnergiewerte(energiewert) {
    let formData = new FormData();
    formData.append("portionSize", energiewert.PortionSize);
    formData.append("kalorien", energiewert.Kalorien);
    formData.append("fett", energiewert.Fett);
    formData.append("kohlenhydrate", energiewert.Kohlenhydrate);
    formData.append("zucker", energiewert.Zucker);
    formData.append("eiweiss", energiewert.Eiweiss);

    setEnergiewertToSession(formData);
}