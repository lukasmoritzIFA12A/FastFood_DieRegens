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

document.getElementById('andereBetragInput').addEventListener('change', function () {
    updateTrinkgeldWert();
});

function updateTrinkgeldWert() {
    let trinkgeld = '';

    const radios = document.querySelectorAll('input[name="betrag"]');
    radios.forEach(radio => {
        if (radio.checked) {
            const euroValue = radio.getAttribute('data-euro'); // Euro-Wert aus dem data-Attribut holen
            if (euroValue === 'Andere') {
                trinkgeld = document.getElementById('andereBetragInput').value;
                trinkgeld = trinkgeld.replace(/[^0-9,.]/g, '').replace('.', ',');
            } else {
                trinkgeld = euroValue;
            }
        }
    });

    if (trinkgeld.trim() === '') {
        document.getElementById('trinkgeld').innerText = '-,-- €';
    } else {
        document.getElementById('trinkgeld').innerText = trinkgeld + ' €';
    }

    sendTrinkgeldToSession(trinkgeld);
}

function sendTrinkgeldToSession(trinkgeld) {
    const formData = new FormData();
    formData.append("trinkgeld", trinkgeld);

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
            if (!data.success) {
                alert("Schwerwiegender Fehler: Konnte Trinkgeld nicht setzen!");
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}