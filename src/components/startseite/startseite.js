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

function setEnergiewertDetails(portionSize, calories, fat, carbs, sugar, protein) {
    document.getElementById('portionSize').textContent = portionSize;
    document.getElementById('calories').textContent = calories;
    document.getElementById('fat').textContent = fat;
    document.getElementById('carbs').textContent = carbs;
    document.getElementById('sugar').textContent = sugar;
    document.getElementById('protein').textContent = protein;
}

function setProductDetailsWithoutEnergiewert(title, image, price, description, ingredients) {
    document.getElementById('energyValuesBtn').style.display = "none";

    const collapseElement = document.getElementById('energyValuesCollapse');
    const collapseInstance = bootstrap.Collapse.getInstance(collapseElement);
    if (collapseInstance) {
        collapseInstance.hide();
    }

    if (!title || title.trim() === "") {
        document.getElementById('productModalLabel').innerText = "Produkt";
    } else {
        document.getElementById('productModalLabel').innerText = title;
    }

    document.getElementById('productImage').src = image;

    if (!price || price.trim() === "") {
        document.getElementById('productPrice').innerText = "--.--" + " €";
    } else {
        document.getElementById('productPrice').innerText = price + " €";
    }

    if (!description || description.trim() === "") {
        document.getElementById('productDescription').innerText = "-Keine Produktbeschreibung vorhanden-";
    } else {
        document.getElementById('productDescription').innerText = description;
    }

    if (!ingredients || ingredients.trim() === "") {
        document.getElementById('productIngredients').innerText = "-Keine Zutaten gefunden-";
    } else {
        document.getElementById('productIngredients').innerText = ingredients;
    }
}

function setProductDetails(title, image, price, description, ingredients, portionSize, calories, fat, carbs, sugar, protein) {
    setProductDetailsWithoutEnergiewert(title, image, price, description, ingredients);

    document.getElementById('energyValuesBtn').style.display = "";

    document.getElementById("energyValuesBtn").addEventListener("click", function() {
        setEnergiewertDetails(portionSize, calories, fat, carbs, sugar, protein);
    });
}

function setMenueDetails(title, image, price, description) {
    document.getElementById('menuModalLabel').innerText = title;
    document.getElementById('menuImage').src = image;
    document.getElementById('menuPrice').innerText = price + " €";
    document.getElementById('menuDescription').innerText = description;
}