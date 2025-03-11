function getImageHTMLSrc(imageBlobString) {
    const rawData = atob(imageBlobString); // Base64 dekodieren
    const mimeType = getMimeType(rawData);
    return 'data:' + mimeType + ';base64,' + imageBlobString;
}

function getMimeType(rawData) {
    const uint8Array = new Uint8Array([...rawData].map(char => char.charCodeAt(0)));
    const blob = new Blob([uint8Array]);
    return blob.type || 'application/octet-stream';
}

// Funktion global verfügbar machen
window.getImageHTMLSrc = getImageHTMLSrc;