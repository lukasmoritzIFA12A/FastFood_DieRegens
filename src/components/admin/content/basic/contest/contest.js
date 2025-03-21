function openContestImage(bild) {
    document.getElementById("modalContestBild").src = getImageHTMLSrc(bild);

    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
}

function contestFreigeben(contestId) {
    let formData = new FormData();
    formData.append("id", contestId);

    fetch("/FastFood/src/components/admin/content/basic/contest/contest-freigeben-handler.php", {
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
                reloadContestTabelle();
            } else {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Etwas ist schiefgelaufen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}

function contestAblehnen(contestId) {
    let formData = new FormData();
    formData.append("id", contestId);

    fetch("/FastFood/src/components/admin/content/basic/contest/contest-ablehnen-handler.php", {
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
                reloadContestTabelle();
            } else {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Etwas ist schiefgelaufen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}

function contestWiderrufen(contestId) {
    let formData = new FormData();
    formData.append("id", contestId);

    fetch("/FastFood/src/components/admin/content/basic/contest/contest-widerrufen-handler.php", {
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
                reloadContestTabelle();
            } else {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert("Etwas ist schiefgelaufen!");
                }
            }
        })
        .catch(error => console.error("Fehler:", error)); // Falls was schiefgeht, loggen!
}

function reloadContestTabelle() {
    fetch("/FastFood/src/components/admin/content/basic/contest/contest-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("unlock").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}