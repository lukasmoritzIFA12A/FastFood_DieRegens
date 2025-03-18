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

function setImageAsFile(imageBlobString, element) {
    const rawData = atob(imageBlobString);
    const mimeType = getMimeType(rawData);

    const byteArray = new Uint8Array(rawData.length);
    for (let i = 0; i < rawData.length; i++) {
        byteArray[i] = rawData.charCodeAt(i);
    }

    const blob = new Blob([byteArray], { type: mimeType });
    const file = new File([blob], 'image.jpg', { type: mimeType });

    const fileInput = document.getElementById(element);
    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    fileInput.files = dataTransfer.files;
}

// Funktion global verfügbar machen
window.getImageHTMLSrc = getImageHTMLSrc;
window.setImageAsFile = setImageAsFile;