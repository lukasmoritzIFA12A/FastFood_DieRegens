function reloadMenueTabelle() {
    fetch("/FastFood/src/components/admin/content/basic/menue/menue-table.php")
        .then(response => response.text())
        .then(data => {
            document.getElementById("see-menu").innerHTML = data;
        })
        .catch(error => console.error("Fehler beim Neuladen der Tabelle:", error));
}