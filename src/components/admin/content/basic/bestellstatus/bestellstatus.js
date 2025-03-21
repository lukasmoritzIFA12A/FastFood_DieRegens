function reloadBestellstatusTabelle() {
    fetch("/FastFood/src/components/admin/content/basic/bestellstatus/bestellstatus-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-orderStatus").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}