function setProductDetails(jsonString) {
    const collapseElement = document.getElementById('energyValuesCollapse');
    const collapseInstance = bootstrap.Collapse.getInstance(collapseElement);
    if (collapseInstance) {
        collapseInstance.hide();
    }

//Falls der Parameter schon geparsed wurde, wird er direkt genutzt
    const produkt = (typeof jsonString === 'string') ? JSON.parse(jsonString) : jsonString;

    if (!produkt.Titel || Object.keys(produkt.Titel).length === 0) {
        document.getElementById('productModalLabel').innerText = "Produkt";
    } else {
        document.getElementById('productModalLabel').innerText = produkt.Titel;
    }

    document.getElementById('productImage').src = getImageHTMLSrc(produkt.bild.bild);

    if (!produkt.Preis || Object.keys(produkt.Preis).length === 0) {
        document.getElementById('productPrice').innerText = "--.--" + " €";
    } else {
        document.getElementById('productPrice').innerText = produkt.Preis + " €";
    }

    if (!produkt.Beschreibung || Object.keys(produkt.Beschreibung).length === 0) {
        document.getElementById('productDescription').innerText = "-Keine Produktbeschreibung vorhanden-";
    } else {
        document.getElementById('productDescription').innerText = produkt.Beschreibung;
    }

    if (!produkt.zutat || Object.keys(produkt.zutat).length === 0) {
        document.getElementById('productIngredients').innerText = "-Keine Zutaten gefunden-";
    } else {
        document.getElementById('productIngredients').innerText = produkt.zutat.map(z => z.ZutatName).join(", ");
    }

    if (!produkt.energiewert || Object.keys(produkt.energiewert).length === 0) {
        document.getElementById('energyValuesBtn').style.display = "none";
    } else {
        document.getElementById('energyValuesBtn').style.display = "";

        document.getElementById("energyValuesBtn").addEventListener("click", function () {
            setEnergiewertDetails(produkt.energiewert);
        });
    }

    document.getElementById("warenkorbProdukt").addEventListener("click", function () {
        sendProductToWarenkorb(produkt.id, document.getElementById('produktQuantityInput').value);
    });
}

function setEnergiewertDetails(energiewert) {
    document.getElementById('portionSize').textContent = energiewert.PortionSize;
    document.getElementById('calories').textContent = energiewert.Kalorien;
    document.getElementById('fat').textContent = energiewert.Fett;
    document.getElementById('carbs').textContent = energiewert.Kohlenhydrate;
    document.getElementById('sugar').textContent = energiewert.Zucker;
    document.getElementById('protein').textContent = energiewert.Eiweiss;
}

function sendProductToWarenkorb(productId, produktQuantityInput, removeFromWarenkorb = false) {
    const formData = new FormData();
    if (removeFromWarenkorb) {
        formData.append("warenkorbIndex", productId);
    } else {
        formData.append("productId", productId);
    }
    formData.append("produktAnzahl", produktQuantityInput);

    fetch("/FastFood/src/components/startseite/produkt/produkt-handler.php", {
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
                    alert("Schwerwiegender Fehler: Konnte Produkt nicht setzen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}

document.getElementById("increaseProduktQuantity")?.addEventListener("click", function() {
    let input = document.getElementById("produktQuantityInput");
    input.value = parseInt(input.value) + 1;
});

document.getElementById("decreaseProduktQuantity")?.addEventListener("click", function() {
    let input = document.getElementById("produktQuantityInput");
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
});