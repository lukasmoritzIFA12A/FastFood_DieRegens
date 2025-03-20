$(document).ready(function () {
    $('#bestellTabelle').DataTable({
        "order": [[0, 'desc']],
        "paging": false,
        "searching": false,
        "info": false,
        "lengthChange": false,
        "language": {
            "emptyTable": "Keine Inhalte gefunden"
        },
        "columnDefs": [
            {"orderable": false, "targets": [-1]}
        ]
    });
});

function deleteBestellung(button) {
    let id = button.getAttribute("data-id");
    const formData = new FormData();
    formData.append("id", id);

    fetch("/FastFood/src/components/admin/content/delete/bestellung/bestellung-delete-handler.php", {
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
                reloadBestellungTabelle();
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

function updateBestellstatus(bestellungId, bestellStatusId) {
    const formData = new FormData();
    formData.append("bestellungId", bestellungId);
    formData.append("bestellStatusId", bestellStatusId);

    fetch("/FastFood/src/components/admin/content/edit/bestellung/bestellung-edit-handler.php", {
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
            if (!data.success) {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Etwas ist schiefgelaufen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}

function reloadBestellungTabelle() {
    fetch("/FastFood/src/components/admin/content/basic/bestellung/bestellung-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("order").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}

function onSelectChange(bestellungId, bestellungstatusId) {
    const selectElement = document.getElementById('selectBestellstatus');

    const placeholderOption = selectElement.querySelector('option[disabled]');
    if (selectElement.value !== "" && placeholderOption) {
        placeholderOption.remove(); // Entferne den Platzhalter, wenn eine Auswahl getroffen wurde
    }
    updateBestellstatus(bestellungId, bestellungstatusId);
}