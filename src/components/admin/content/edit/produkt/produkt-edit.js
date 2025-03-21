document.getElementById("produktEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/edit/produkt/produkt-edit-handler.php", {
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
                const modalElement = document.getElementById('produktModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();

                reloadProduktTabelle();
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

let zutatenEdit = new Map();

function setProdukt(jsonString) {
    clearAllZutatenFromEditProdukt();

    const produkt = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    if (!produkt.energiewert || Object.keys(produkt.energiewert).length === 0) {
        document.getElementById("editProduktPortionSize").value = '';
        document.getElementById("editProduktCalories").value = '';
        document.getElementById("editProduktFat").value = '';
        document.getElementById("editProduktCarbohydrates").value = '';
        document.getElementById("editProduktSugar").value = '';
        document.getElementById("editProduktProtein").value = '';
        setEditButtonForEnergiewerte(false);
    } else {
        document.getElementById("editProduktPortionSize").value = produkt.energiewert.PortionSize;
        document.getElementById("editProduktCalories").value = produkt.energiewert.Kalorien;
        document.getElementById("editProduktFat").value = produkt.energiewert.Fett;
        document.getElementById("editProduktCarbohydrates").value = produkt.energiewert.Kohlenhydrate;
        document.getElementById("editProduktSugar").value = produkt.energiewert.Zucker;
        document.getElementById("editProduktProtein").value = produkt.energiewert.Eiweiss;
        setEditButtonForEnergiewerte(true);
        setEnergiewerte(produkt.energiewert);
    }

    document.getElementById("produktId").value = produkt.id;

    setImageAsFile(produkt.bild.bild, "produktBild");
    document.getElementById("produktImageLoaded").src = getImageHTMLSrc(produkt.bild.bild);

    document.getElementById("produktTitle").value = produkt.Titel;
    document.getElementById("produktDescription").value = !produkt.Beschreibung ? '' : produkt.Beschreibung;

    document.getElementById("productPrice").value = produkt.Preis;
    document.getElementById("productStock").checked = produkt.ausverkauft === '1';

    if (produkt.zutat) {
        produkt.zutat.forEach(zutat => {
            addZutatToEditProdukt(zutat.ZutatName, zutat.id.toString());
        });
    }
}

function addZutatToEditProdukt(zutatName, zutatId) {
    if (zutatenEdit.has(zutatId)) {
        alert("Zutat schon zu Produkt hinzugefügt!");
        return;
    }

    onPressedButtonAnimation(zutatName+"Edit");

    const addedZutatList = document.getElementById('addedEditProduktZutatenList');
    const noZutatMessage = document.getElementById('noEditProduktZutatenMessage');
    if (noZutatMessage) {
        noZutatMessage.style.display = 'none';
    }

    zutatenEdit.set(zutatId, zutatName);
    document.getElementById('editProduktZutatenInput').value = Array.from(zutatenEdit.keys()).join(",");

    // Erstelle eine neue Zeile
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="d-flex justify-content-between align-items-center addedZutat">
          <span class="zutat-name">${zutatName}</span>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeZutatFromEditProdukt(this, ${zutatId})">Entfernen</button>
        </td>
      `;
    addedZutatList.appendChild(newRow);
}

function removeZutatFromEditProdukt(button, index) {
    const row = button.closest('tr');
    row.remove();

    zutatenEdit.delete(index.toString());
    const zutatenInput = document.getElementById('editProduktZutatenInput');
    zutatenInput.value = Array.from(zutatenEdit.keys()).join(",");

    const neuZutaten = document.querySelectorAll('#addedEditProduktZutatenList .addedZutat');
    if (neuZutaten.length === 0) {
        const noZutatMessage = document.getElementById('noEditProduktZutatenMessage');
        noZutatMessage.style.display = '';
    }
}

function clearAllZutatenFromEditProdukt() {
    zutatenEdit.clear();
    const zutaten = document.querySelectorAll('#addedEditProduktZutatenList .addedZutat');
    zutaten.forEach(zutat => {
        zutat.remove();
    });

    document.getElementById('noEditProduktZutatenMessage').style.display = '';
    document.getElementById('editProduktZutatenInput').value = '';
}

function openEditProductZutatModal() {
    clearZutatSearchInput();

    document.getElementById('addEditProduktZutatModal').addEventListener('hidden.bs.modal', function handleModalClose() {
        document.getElementById('addEditProduktZutatModal').removeEventListener('hidden.bs.modal', handleModalClose);
        const modal = new bootstrap.Modal(document.getElementById('produktModal'));
        modal.show();
    });
}

function openEditProductEnergiewerteModal() {
    document.getElementById('addEditProduktEnergiewerteModal').addEventListener('hidden.bs.modal', function handleModalClose() {
        document.getElementById('addEditProduktEnergiewerteModal').removeEventListener('hidden.bs.modal', handleModalClose);
        const modal = new bootstrap.Modal(document.getElementById('produktModal'));
        modal.show();
    });
}