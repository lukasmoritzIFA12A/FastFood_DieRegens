document.getElementById("menueForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/admin/content/add/menue/menue-add-handler.php", {
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

let produkte = new Map();

function filterProducts() {
    const searchInput = document.getElementById('productSearch');
    const filter = searchInput.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#productListTable tbody tr');
    rows.forEach(row => {
        const productName = row.querySelector('.product-name').textContent.toLowerCase().trim();
        row.style.display = productName.includes(filter) ? '' : 'none';
    });
}

// Produkt zum Menü hinzufügen
function addProductToMenu(productName, productId) {
    if (produkte.has(productId)) {
        alert("Produkt schon zu Menü hinzugefügt!");
        return;
    }

    onPressedButtonAnimation(productName+"Add");

    const addedProductsList = document.getElementById('addedProductsList');

    const noProductsMessage = document.getElementById('noProductsMessage');
    if (noProductsMessage) {
        noProductsMessage.style.display = 'none';
    }

    produkte.set(productId, productName);
    document.getElementById('produkteInput').value = Array.from(produkte.keys()).join(",");

    // Erstelle eine neue Zeile
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="d-flex justify-content-between align-items-center addedProduct">
          <span class="product-name">${productName}</span>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeProductFromMenu(this, ${productId})">Entfernen</button>
        </td>
      `;
    addedProductsList.appendChild(newRow);
}

// Produkt aus der Menü-Liste entfernen
function removeProductFromMenu(button, index) {
    const row = button.closest('tr');
    row.remove();

    produkte.delete(index);
    const produkteInput = document.getElementById('produkteInput');
    produkteInput.value = Array.from(produkte.keys()).join(",");

    const neuProdukte = document.querySelectorAll('#addedProductsList .addedProduct');
    if (neuProdukte.length === 0) {
        const noProduktMessage = document.getElementById('noProductsMessage');
        noProduktMessage.style.display = '';
    }
}

function clearProductSearchInput() {
    const input = document.getElementById("productSearch");
    if (input) input.value = "";

    filterProducts();
}