function reloadZutatTabelle() {
    fetch("/FastFood/src/components/admin/content/basic/zutat/zutat-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-zutat").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}