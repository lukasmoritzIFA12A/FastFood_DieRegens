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

        document.getElementById("energyValuesBtn").addEventListener("click", function () {
            setEnergiewertDetails(produkt.energiewert);
        });
    }

    document.getElementById("warenkorbProdukt").addEventListener("click", function () {
        sendProductToWarenkorb(produkt.id);
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

function sendProductToWarenkorb(productId) {
    const formData = new FormData();
    formData.append("productId", productId);

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
                window.location.href = "../startseite/startseite.php"; // Weiterleiten
            } else {
                alert("Schwerwiegender Fehler: Konnte Produkt nicht setzen!");
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}