document.getElementById("rabattForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Verhindert Standard-Weiterleitung

    let formData = new FormData(this);

    fetch("/FastFood/src/components/warenkorb/rabatt/rabatt-handler.php", {
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
                document.getElementById("message").innerText = "";

                checkRabattCode(data.rabatt);
                onRabattCodeValid(data.rabattcode);
            } else {
                if (data.message) {
                    document.getElementById("message").innerText = data.message;
                } else {
                    document.getElementById("message").innerText = "Etwas ist schiefgelaufen!";
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
});

function checkRabattCode(rabattEuro) {
    document.getElementById('rabattEuro').innerText = rabattEuro;
}

function onRabattCodeValid(rabattcode) {
    const submitButton = document.getElementById('submitRabatt');
    const checkIcon = document.getElementById('checkIcon');

    submitButton.classList.remove('btn-outline-primary');
    submitButton.classList.add('btn-success');
    checkIcon.classList.remove('d-none');
    checkIcon.classList.add('fade');

    setTimeout(() => {
        checkIcon.classList.add('show');
    }, 10);

    setTimeout(() => {
        submitButton.classList.remove('btn-success');
        submitButton.classList.add('btn-outline-primary');
        checkIcon.classList.remove('show', 'fade');
        checkIcon.classList.add('d-none');

        setRabattInputAsDeactivated(rabattcode);
    }, 1000);
}

function setRabattInputAsDeactivated(rabattcode) {
    document.getElementById('rabattcodeAnzeige').innerText = rabattcode;

    document.getElementById('ohneRabattCodeFeld').style.display = 'none';
    document.getElementById('mitRabattCodeFeld').style.display = '';
}

function setRabattInputAsActivated() {
    document.getElementById('rabattcode').innerText = '';

    document.getElementById('ohneRabattCodeFeld').style.display = '';
    document.getElementById('mitRabattCodeFeld').style.display = 'none';
}