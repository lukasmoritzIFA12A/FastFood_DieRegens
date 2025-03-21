function reloadRabattTabelle() {
    fetch("/FastFood/src/components/admin/content/basic/rabatt/rabatt-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-rabatt").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}