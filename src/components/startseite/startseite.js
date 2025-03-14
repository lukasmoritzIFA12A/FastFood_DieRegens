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