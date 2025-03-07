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

function setProductDetails(title, image, price, description, stock, ingredients) {
    document.getElementById('productModalLabel').innerText = title;
    document.getElementById('productImage').src = image;
    document.getElementById('productPrice').innerText = price + " €";
    document.getElementById('productDescription').innerText = description;

    // Lagerbestand prüfen
    let stockElement = document.getElementById('productStock');
    if (stock < 5) {
        stockElement.innerText = "Nur noch wenige auf Lager!";
        stockElement.classList.add("text-danger"); // Rot färben
    } else {
        stockElement.innerText = stock + " Stück verfügbar";
        stockElement.classList.remove("text-danger");
    }

    if (ingredients != null) {
        ingredients = JSON.parse(ingredients);

        // Zutatenliste befüllen
        let ingredientsList = document.getElementById('productIngredients');
        ingredientsList.innerHTML = "";
        ingredients.forEach(zutat => {
            let li = document.createElement("li");
            li.innerText = zutat;
            ingredientsList.appendChild(li);
        });
    }

    let modal = new bootstrap.Modal(document.getElementById('productModal'));
    modal.show();
}

function setMenueDetails(title, image, price, description) {
    document.getElementById('menuModalLabel').innerText = title;
    document.getElementById('menuImage').src = image;
    document.getElementById('menuPrice').innerText = price + " €";
    document.getElementById('menuDescription').innerText = description;

    let modal = new bootstrap.Modal(document.getElementById('menuModal'));
    modal.show();
}
