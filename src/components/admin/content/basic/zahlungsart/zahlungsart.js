function reloadZahlungsartTabelle() {
    fetch("/FastFood/src/components/admin/content/basic/zahlungsart/zahlungsart-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-zahlungsart").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}