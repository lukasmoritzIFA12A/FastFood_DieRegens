function sendRabattForm() {
    let input = document.getElementById('rabattcode');
    input.required = true;
    let validity = input.reportValidity();
    input.required = false;
    if (!validity) {
        return;
    }

    let formData = new FormData();
    formData.append('rabattcode', input.value);

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
                onRabattCodeValid();
            } else {
                if (data.message) {
                    document.getElementById("message").innerText = data.message;
                } else {
                    document.getElementById("message").innerText = "Etwas ist schiefgelaufen!";
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}

function onRabattCodeValid() {
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

        window.location.href = "../warenkorb/warenkorb.php";
    }, 1000);
}

function setRabattInputAsDeactivated(rabattcode, rabatt) {
    document.getElementById('rabattcodeAnzeige').innerText = rabattcode + " - " + rabatt + " %";

    document.getElementById('ohneRabattCodeFeld').style.display = 'none';
    document.getElementById('mitRabattCodeFeld').style.display = '';
}

function setRabattInputAsActivated() {
    document.getElementById('rabattcode').value = '';

    document.getElementById('ohneRabattCodeFeld').style.display = '';
    document.getElementById('mitRabattCodeFeld').style.display = 'none';

    resetRabatt();
}

function resetRabatt() {
    fetch("/FastFood/src/components/warenkorb/rabatt/rabatt-handler.php", {
        method: "POST",
        body: null
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP-Fehler! Status: ${response.status}`);
            }

            window.location.href = "../warenkorb/warenkorb.php";
            return response.json();
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}