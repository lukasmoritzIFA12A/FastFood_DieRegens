let zutaten = new Map();
let counter = 0;

// Filterfunktion im Modal
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
function addProductToMenu(productName) {
    const addedProductsList = document.getElementById('addedProductsList');
    // Entferne "Keine Produkte"-Nachricht, falls vorhanden
    const noProductsMessage = document.getElementById('noProductsMessage');
    if (noProductsMessage) {
        noProductsMessage.remove();
    }
    // Erstelle eine neue Zeile
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="d-flex justify-content-between align-items-center">
          <span class="product-name">${productName}</span>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeProductFromMenu(this)">Entfernen</button>
        </td>
      `;
    addedProductsList.appendChild(newRow);
}

// Produkt aus der Menü-Liste entfernen
function removeProductFromMenu(button) {
    const row = button.closest('tr');
    row.remove();
    // Falls keine Zeilen mehr vorhanden, füge Platzhalter-Nachricht hinzu
    const addedProductsList = document.getElementById('addedProductsList');
    if (addedProductsList.children.length === 0) {
        const messageRow = document.createElement('tr');
        messageRow.id = 'noProductsMessage';
        messageRow.innerHTML = `<td class="text-center text-muted">Es wurden noch keine Produkte hinzugefügt.</td>`;
        addedProductsList.appendChild(messageRow);
    }
}

function clearProductSearchInput() {
    const input = document.getElementById("productSearch");
    if (input) input.value = "";

    filterProducts();
}

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
function addZutatToProdukt(zutatName) {
    const addedZutatenList = document.getElementById('addedZutatenList');

    const noZutatMessage = document.getElementById('noZutatenMessage');
    if (noZutatMessage) {
        noZutatMessage.style.display = 'none';
    }

    let currentCounter = counter;

    const zutatenInput = document.getElementById('zutatenInput');
    zutaten.set(currentCounter, zutatName);
    zutatenInput.value = Array.from(zutaten.values()).join(",");

    // Erstelle eine neue Zeile
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="d-flex justify-content-between align-items-center addedZutat">
          <span class="product-name">${zutatName}</span>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeZutatFromProdukt(this, ${currentCounter})">Entfernen</button>
        </td>
      `;
    addedZutatenList.appendChild(newRow);
    counter++;
}

// Zutat aus der Produkt-Liste entfernen
function removeZutatFromProdukt(button, index) {
    const row = button.closest('tr');
    row.remove();

    zutaten.delete(index);
    const zutatenInput = document.getElementById('zutatenInput');
    zutatenInput.value = Array.from(zutaten.values()).join(",");

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