function reloadProduktTabelle() {
    fetch("/FastFood/src/components/admin/content/basic/produkt/produkt-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-product").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}