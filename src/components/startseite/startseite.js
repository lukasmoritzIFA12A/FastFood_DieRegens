document.addEventListener("DOMContentLoaded", function () {
    const burgerBtn = document.getElementById("burgerBtn");
    const menuBtn = document.getElementById("menuBtn");
    const burgerContent = document.getElementById("burgerContent");
    const menuContent = document.getElementById("menuContent");

    // Funktion für den Wechsel der Inhalte
    function switchContent(toShow, toHide) {
        // Entferne "active" von zu versteckendem Inhalt
        toHide.classList.remove("active");
        setTimeout(() => {
            toHide.style.display = "none"; // Nach der Transition ausblenden

            // Blende das neue Element ein
            toShow.style.display = "block";
            setTimeout(() => {
                toShow.classList.add("active");
            }, 20); // Kleiner Delay sichert, dass Transition getriggert wird
        }, 500); // Timeout passend zur CSS-Transitionszeit (opacity)
    }

    // Event-Listener: Burger-Button klickt
    burgerBtn.addEventListener("click", function () {
        switchContent(burgerContent, menuContent);
    });

    // Event-Listener: Menü-Button klickt
    menuBtn.addEventListener("click", function () {
        switchContent(menuContent, burgerContent);
    });

    // Initialer Zustand: Burger anzeigen
    burgerContent.style.display = "block"; // Direkt in DOM sichtbar
    setTimeout(() => {
        burgerContent.classList.add("active"); // Smooth sichtbar machen
    }, 20); // Exakter Moment für Transition
});

function setProductDetails(jsonString) {
    const collapseElement = document.getElementById('energyValuesCollapse');
    const collapseInstance = bootstrap.Collapse.getInstance(collapseElement);
    if (collapseInstance) {
        collapseInstance.hide();
    }

//Falls der Parameter schon geparsed wurde, wird er direkt genutzt
    const produkt = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    if (Object.keys(produkt.Titel).length === 0) {
        document.getElementById('productModalLabel').innerText = "Produkt";
    } else {
        document.getElementById('productModalLabel').innerText = produkt.Titel;
    }

    document.getElementById('productImage').src = getImageHTMLSrc(produkt.bild.bild);

    if (Object.keys(produkt.Preis).length === 0) {
        document.getElementById('productPrice').innerText = "--.--" + " €";
    } else {
        document.getElementById('productPrice').innerText = produkt.Preis + " €";
    }

    if (Object.keys(produkt.Beschreibung).length === 0) {
        document.getElementById('productDescription').innerText = "-Keine Produktbeschreibung vorhanden-";
    } else {
        document.getElementById('productDescription').innerText = produkt.Beschreibung;
    }

    if (Object.keys(produkt.zutat).length === 0) {
        document.getElementById('productIngredients').innerText = "-Keine Zutaten gefunden-";
    } else {
        document.getElementById('productIngredients').innerText = produkt.zutat.map(z => z.ZutatName).join(", ");
    }

    if (Object.keys(produkt.energiewert).length === 0) {
        document.getElementById('energyValuesBtn').style.display = "none";
    } else {
        document.getElementById('energyValuesBtn').style.display = "";

        document.getElementById("energyValuesBtn").addEventListener("click", function() {
            setEnergiewertDetails(produkt.energiewert);
        });
    }
}

function setEnergiewertDetails(energiewert) {
    document.getElementById('portionSize').textContent = energiewert.PortionSize;
    document.getElementById('calories').textContent = energiewert.Kalorien;
    document.getElementById('fat').textContent = energiewert.Fett;
    document.getElementById('carbs').textContent = energiewert.Kohlenhydrate;
    document.getElementById('sugar').textContent = energiewert.Zucker;
    document.getElementById('protein').textContent = energiewert.Eiweiss;
}

function setMenueDetails(jsonString) {
    const collapseElement = document.getElementById('menueProductListCollapse');
    const collapseInstance = bootstrap.Collapse.getInstance(collapseElement);
    if (collapseInstance) {
        collapseInstance.hide();
    }

//Falls der Parameter schon geparsed wurde, wird er direkt genutzt
    const menue = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    if (Object.keys(menue.Titel).length === 0) {
        document.getElementById('menuModalLabel').innerText = "Menü";
    } else {
        document.getElementById('menuModalLabel').innerText = menue.Titel;
    }

    if (Object.keys(menue.Beschreibung).length === 0) {
        document.getElementById('menuDescription').innerText = "-Keine Menübeschreibung vorhanden-";
    } else {
        document.getElementById('menuDescription').innerText = menue.Beschreibung;
    }

    document.getElementById('menuImage').src = getImageHTMLSrc(menue.bild.bild);

    if (Object.keys(menue.Preis).length === 0) {
        document.getElementById('menuPrice').innerText = "--.--" + " €";
    } else {
        document.getElementById('menuPrice').innerText = menue.Preis + " €";
    }

    loadProducts(menue);
}

function loadProducts(menue) {
    if (Object.keys(menue.produkte).length === 0) {
        document.getElementById('menueProductListBtn').style.display = "none";
        return;
    }

    document.getElementById('menueProductListBtn').style.display = "";

    const productList = document.getElementById('menueProductList');
    productList.innerHTML = '';
    menue.produkte.forEach(product => {
        const li = document.createElement('li');
        li.classList.add('list-group-item', 'list-group-item-action');
        li.style.cursor = 'pointer';
        li.innerHTML = `<strong>${product.Titel}</strong> - ${product.Preis}`;
        li.onclick = () => openProductModal(product, menue);
        li.setAttribute('data-bs-toggle', 'modal');
        li.setAttribute('data-bs-target', '#productModal');
        productList.appendChild(li);
    });
}

function openProductModal(product, menue) {
    document.getElementById('productModal').addEventListener('hidden.bs.modal', function handleModalClose () {
        document.getElementById('productModal').removeEventListener('hidden.bs.modal', handleModalClose);
        setMenueDetails(menue);
        const modal = new bootstrap.Modal(document.getElementById('menuModal'));
        modal.show();
    });

    setProductDetails(product);
}