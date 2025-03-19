// Beim Laden prüfen, ob unser Key noch existiert
if (!localStorage.getItem("sessionID")) {
    localStorage.setItem("sessionID", Date.now().toString());
}

setInterval(() => {
    if (!localStorage.getItem("sessionID")) {
        console.log("Cookies & Site Data wurden wohl gelöscht! Neuladen...");
        location.reload();
    }
}, 1000);