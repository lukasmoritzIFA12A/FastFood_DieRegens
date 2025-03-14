let lastSelected = null;

document.querySelectorAll('input[name="betrag"]').forEach((radio) => {
    radio.addEventListener('change', () => {
        updateTrinkgeldWert();

        const andereButton = document.getElementById('btnAndere');
        document.getElementById("andereBetragInput").disabled = !andereButton.checked;
    });

    radio.addEventListener('click', function (e) {
        if (this === lastSelected) {
            this.checked = false;
            lastSelected = null;
            updateTrinkgeldWert();
            e.preventDefault();
        } else {
            lastSelected = this;
        }

        const andereBetragInput = document.getElementById('andereBetragInput');
        andereBetragInput.disabled = !document.getElementById('btnAndere').checked;
    });
});

document.getElementById('andereBetragInput').addEventListener('keypress', function (event) {
    const allowedChars = /[0-9,]/;
    if (!allowedChars.test(event.key) && event.key !== 'Backspace' && event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') {
        event.preventDefault();
    }
});

document.getElementById('andereBetragInput').addEventListener('change', function () {
    updateTrinkgeldWert();
});

function updateTrinkgeldWert() {
    let trinkgeld = '0.00';
    let istAndereTrinkgeld = false;

    const radios = document.querySelectorAll('input[name="betrag"]');
    for (const radio of radios) {
        if (radio.checked) {
            const euroValue = radio.getAttribute('data-euro'); // Euro-Wert aus dem data-Attribut holen
            if (euroValue === 'Andere') {
                istAndereTrinkgeld = true;
                trinkgeld = document.getElementById('andereBetragInput').value;
            } else {
                trinkgeld = euroValue;
            }
            break;
        }
    }
    sendTrinkgeldToSession(trinkgeld, istAndereTrinkgeld);
}

function sendTrinkgeldToSession(trinkgeld, istAndereTrinkgeld) {
    const formData = new FormData();
    formData.append("trinkgeld", trinkgeld);
    formData.append("andereTrinkgeld", istAndereTrinkgeld ? "1" : "0");

    fetch("/FastFood/src/components/warenkorb/trinkgeld/trinkgeld-handler.php", {
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
                window.location.href = "../warenkorb/warenkorb.php";
            } else {
                alert("Schwerwiegender Fehler: Konnte Trinkgeld nicht setzen!");
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}