function setMenueDetails(jsonString) {
    const collapseElement = document.getElementById('menueProductListCollapse');
    const collapseInstance = bootstrap.Collapse.getInstance(collapseElement);
    if (collapseInstance) {
        collapseInstance.hide();
    }

//Falls der Parameter schon geparsed wurde, wird er direkt genutzt
    const menue = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    if (!menue.Titel || Object.keys(menue.Titel).length === 0) {
        document.getElementById('menuModalLabel').innerText = "Menü";
    } else {
        document.getElementById('menuModalLabel').innerText = menue.Titel;
    }

    if (!menue.Beschreibung || Object.keys(menue.Beschreibung).length === 0) {
        document.getElementById('menuDescription').innerText = "-Keine Menübeschreibung vorhanden-";
    } else {
        document.getElementById('menuDescription').innerText = menue.Beschreibung;
    }

    document.getElementById('menuImage').src = getImageHTMLSrc(menue.bild.bild);

    if (!menue.Preis || Object.keys(menue.Preis).length === 0) {
        document.getElementById('menuPrice').innerText = "--.--" + " €";
    } else {
        document.getElementById('menuPrice').innerText = menue.Preis + " €";
    }

    loadProducts(menue);

    document.getElementById("warenkorbMenu").addEventListener("click", function () {
        sendMenuToWarenkorb(menue.id);
    });
}

function loadProducts(menue) {
    if (!menue.produkte || Object.keys(menue.produkte).length === 0) {
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
    setProductDetails(product);

    document.getElementById('productModal').addEventListener('hidden.bs.modal', function handleModalClose() {
        document.getElementById('productModal').removeEventListener('hidden.bs.modal', handleModalClose);
        setMenueDetails(menue);
        const modal = new bootstrap.Modal(document.getElementById('menuModal'));
        modal.show();
    });
}

function sendMenuToWarenkorb(menuId, removeFromWarenkorb = false) {
    const formData = new FormData();
    if (removeFromWarenkorb) {
        formData.append("warenkorbIndex", menuId);
    } else {
        formData.append("menuId", menuId);
    }

    fetch("/FastFood/src/components/startseite/menu/menu-handler.php", {
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
                if (data.reloadWarenkorb) {
                    window.location.href = "../warenkorb/warenkorb.php";
                    return;
                }

                window.location.href = "../startseite/startseite.php"; // Weiterleiten
            } else {
                if (!data.loggedIn) {
                    const loginModal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
                    loginModal.show();
                } else {
                    alert("Schwerwiegender Fehler: Konnte Menü nicht setzen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}