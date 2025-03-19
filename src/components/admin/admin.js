let zutaten = new Map();
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

function showImage(event, element) {
    const file = event.target.files[0]; // Das erste ausgewählte File

    if (!file) {
        alert("Kein Bild ausgewählt!");
        return;
    }

    const allowedExtensions = ['jpg', 'jpeg', 'png'];
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];

    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        alert("Die Datei ist zu groß! (Maximal 5MB)");
        return;
    }

    const fileExtension = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(fileExtension)) {
        alert("Ungültiges Dateiformat! Bitte wähle ein Bild im JPG, JPEG oder PNG Format.");
        return;
    }

    if (!allowedTypes.includes(file.type)) {
        alert("Ungültiger Dateityp! Bitte wähle ein JPG, JPEG oder PNG Bild.");
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById(element);
        img.src = e.target.result; // Setze die Quelle des Bildes auf die geladene Datei
    };
    reader.readAsDataURL(file);
}