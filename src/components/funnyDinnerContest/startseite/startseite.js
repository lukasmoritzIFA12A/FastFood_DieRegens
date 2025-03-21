function bildHochladen(isLoggedIn) {
    if (isLoggedIn) {
        const modal = new bootstrap.Modal(document.getElementById('uploadModal'));
        modal.show();
    } else {
        const modal = new bootstrap.Modal(document.getElementById('loginRequiredModal'));
        modal.show();
    }
}

function checkSelection() {
    const selected = document.querySelector('input[name="orderOption"]:checked');

    if (selected) {
        document.getElementById("bildAuswahlButton").disabled = false;
    }
}

function bildAuswahl() {
    document.getElementById('fileInput').click();
}

document.getElementById('fileInput').addEventListener('change', function () {
    const selected = document.querySelector('input[name="orderOption"]:checked');
    const bestellungId = selected.id;

    const fileInput = document.getElementById('fileInput');

    const formData = new FormData();
    formData.append("id", bestellungId);
    formData.append("fileInput", fileInput.files[0]);

    fetch("/FastFood/src/components/funnyDinnerContest/startseite/startseite-handler.php", {
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
                const uploadModal = document.getElementById('uploadModal');
                const modalInstance = bootstrap.Modal.getInstance(uploadModal) || new bootstrap.Modal(uploadModal);
                modalInstance.hide();

                const modal = new bootstrap.Modal(document.getElementById('contestHochgeladenModal'));
                modal.show();
            } else {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Etwas ist schiefgelaufen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
});