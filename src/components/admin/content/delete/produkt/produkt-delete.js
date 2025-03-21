function deleteProdukt(button) {
    let id = button.getAttribute("data-id");
    const formData = new FormData();
    formData.append("id", id);

    fetch("/FastFood/src/components/admin/content/delete/produkt/produkt-delete-handler.php", {
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
                reloadProduktTabelle();
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