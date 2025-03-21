document.getElementById("produktForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/add/produkt/produkt-add-handler.php", {
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

let zutaten = new Map();

// Filterfunktion im Modal
function filterZutaten() {
    const searchInput = document.getElementById('zutatSearch');
    const filter = searchInput.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#zutatListTable tbody tr');
    rows.forEach(row => {
        const zutatName = row.querySelector('.zutat-name').textContent.toLowerCase().trim();
        row.style.display = zutatName.includes(filter) ? '' : 'none';
    });
}

// Zutat zum Produkt hinzufügen
function addZutatToProdukt(zutatName, zutatId) {
    if (zutaten.has(zutatId)) {
        alert("Zutat schon zu Produkt hinzugefügt!");
        return;
    }

    onPressedButtonAnimation(zutatName+"Add");

    const addedZutatenList = document.getElementById('addedZutatenList');

    const noZutatMessage = document.getElementById('noZutatenMessage');
    if (noZutatMessage) {
        noZutatMessage.style.display = 'none';
    }

    zutaten.set(zutatId, zutatName);
    document.getElementById('zutatenInput').value = Array.from(zutaten.keys()).join(",");

    // Erstelle eine neue Zeile
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="d-flex justify-content-between align-items-center addedZutat">
          <span class="zutat-name">${zutatName}</span>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeZutatFromProdukt(this, ${zutatId})">Entfernen</button>
        </td>
      `;
    addedZutatenList.appendChild(newRow);
}

// Zutat aus der Produkt-Liste entfernen
function removeZutatFromProdukt(button, index) {
    const row = button.closest('tr');
    row.remove();

    zutaten.delete(index);
    const zutatenInput = document.getElementById('zutatenInput');
    zutatenInput.value = Array.from(zutaten.keys()).join(",");

    const neuZutaten = document.querySelectorAll('#addedZutatenList .addedZutat');
    if (neuZutaten.length === 0) {
        const noZutatMessage = document.getElementById('noZutatenMessage');
        noZutatMessage.style.display = '';
    }
}

function clearZutatSearchInput() {
    const input = document.getElementById("zutatSearch");
    if (input) input.value = "";

    filterZutaten();
}