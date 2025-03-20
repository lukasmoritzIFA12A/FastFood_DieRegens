<div class="modal fade" id="zahlungsartModal" tabindex="-1" aria-labelledby="zahlungsartAnpassen"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="zahlungsartAnpassen">Zahlungsart bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Schließen"></button>
            </div>
            <form method="POST" id="zahlungsartEditForm" action="#">
                <div class="modal-body">
                    <div>
                        <label for="editZahlungsartId" class="form-label mt-2">ID</label>
                        <input type="text" class="form-control disabledInput" id="editZahlungsartId" name="id" required>
                    </div>
                    <div>
                        <label for="editZahlungsartArt" class="form-label mt-2">Zahlungsart</label>
                        <input type="text" class="form-control" id="editZahlungsartArt" name="art" required>
                    </div>

                    <label for="editZahlungsartBild" class="form-label">Zahlungsart Bild hochladen</label>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="editZahlungsartBild" name="bild" onchange="showImage(event, 'zahlungsartImageLoaded')">
                    </div>
                    <div class="mb-3">
                        <img alt="Zahlungsart Bild"
                             class="img-thumbnail" id="zahlungsartImageLoaded" width="100" height="100"
                             onerror="this.src='../../../assets/img/noimage.jpg';">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                    <button type="submit" class="btn btn-primary">Speichern</button>
                </div>
            </form>
        </div>
    </div>
</div>