document.getElementById("menueForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/menue/menue-handler.php", {
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

document.getElementById("menueEditForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);
    formData.append('update', '1');

    fetch("/FastFood/src/components/admin/content/menue/menue-handler.php", {
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
                const modalElement = document.getElementById('menueModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                modalInstance.hide();

                reloadMenueTabelle();
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

function deleteMenue(button) {
    let id = button.getAttribute("data-id");
    const formData = new FormData();
    formData.append("delete", "1");
    formData.append("id", id);

    fetch("/FastFood/src/components/admin/content/menue/menue-handler.php", {
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
                reloadMenueTabelle();
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

function reloadMenueTabelle() {
    fetch("/FastFood/src/components/admin/content/menue/menue-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-menu").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}

let produkteEdit = new Map();

function setMenue(jsonString) {
    clearAllProductsFromEditMenu();

    const menue = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    document.getElementById("menueid").value = menue.id;

    setImageAsFile(menue.bild.bild, "menueBild");
    document.getElementById("menuImageLoaded").src = getImageHTMLSrc(menue.bild.bild);

    document.getElementById("menuTitle").value = menue.Titel;
    document.getElementById("menuDescription").value = !menue.Beschreibung ? '' : menue.Beschreibung;

    if (menue.produkte) {
        menue.produkte.forEach(product => {
            addProductToEditMenu(product.Titel, product.id.toString());
        });
    }
}

function clearAllProductsFromEditMenu() {
    produkteEdit.clear();
    const produkte = document.querySelectorAll('#addedEditMenueProductsList .addedProduct');
    produkte.forEach(product => {
        product.remove();
    });

    document.getElementById('noEditMenueProductsMessage').style.display = '';
    document.getElementById('editMenueProdukteInput').value = '';
}

function addProductToEditMenu(productName, productId) {
    if (produkteEdit.has(productId)) {
        alert("Produkt schon zu Menü hinzugefügt!");
        return;
    }

    const addedProductsList = document.getElementById('addedEditMenueProductsList');
    const noProductsMessage = document.getElementById('noEditMenueProductsMessage');
    if (noProductsMessage) {
        noProductsMessage.style.display = 'none';
    }

    produkteEdit.set(productId, productName);
    document.getElementById('editMenueProdukteInput').value = Array.from(produkteEdit.keys()).join(",");

    // Erstelle eine neue Zeile
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="d-flex justify-content-between align-items-center addedProduct">
          <span class="product-name">${productName}</span>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeProductFromEditMenu(this, ${productId})">Entfernen</button>
        </td>
      `;
    addedProductsList.appendChild(newRow);
}

function removeProductFromEditMenu(button, index) {
    const row = button.closest('tr');
    row.remove();

    produkteEdit.delete(index.toString());
    const produkteInput = document.getElementById('editMenueProdukteInput');
    produkteInput.value = Array.from(produkteEdit.keys()).join(",");

    const neuProdukte = document.querySelectorAll('#addedEditMenueProductsList .addedProduct');
    if (neuProdukte.length === 0) {
        const noProduktMessage = document.getElementById('noEditMenueProductsMessage');
        noProduktMessage.style.display = '';
    }
}

function openEditMenueProductModal() {
    clearProductSearchInput();

    document.getElementById('addEditMenueProductModal').addEventListener('hidden.bs.modal', function handleModalClose() {
        document.getElementById('addEditMenueProductModal').removeEventListener('hidden.bs.modal', handleModalClose);
        const modal = new bootstrap.Modal(document.getElementById('menueModal'));
        modal.show();
    });
}