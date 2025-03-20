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

function onPressedButtonAnimation(checkIconElement) {
    const checkIcon = document.getElementById(checkIconElement);

    checkIcon.classList.remove('d-none');
    checkIcon.classList.add('fade');

    setTimeout(() => {
        checkIcon.classList.add('show');
    }, 10);

    setTimeout(() => {
        checkIcon.classList.remove('show', 'fade');
        checkIcon.classList.add('d-none');
    }, 750);
}