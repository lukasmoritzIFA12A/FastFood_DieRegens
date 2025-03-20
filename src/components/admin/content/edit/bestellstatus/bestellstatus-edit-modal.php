<div class="modal fade" id="bestellstatusModal" tabindex="-1" aria-labelledby="bestellstatusAnpassen"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="bestellstatusAnpassen">Bestellstatus bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Schließen"></button>
            </div>
            <form method="POST" id="bestellstatusEditForm" action="#">
                <div class="modal-body">
                    <div>
                        <label for="id" class="form-label mt-2">ID</label>
                        <input type="text" class="form-control disabledInput" id="produktid" name="id" required>
                    </div>
                    <div>
                        <label for="status" class="form-label mt-2">Bestellstatus</label>
                        <input type="text" class="form-control" id="status" name="status" required>
                    </div>
                    <div>
                        <label for="farbe" class="form-label mt-2">Farbe</label>
                        <input type="color" class="form-control" id="farbe" name="farbe" required>
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