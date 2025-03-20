<div class="modal fade" id="rabattModal" tabindex="-1" aria-labelledby="rabattAnpassen"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="rabattAnpassen">Rabatt bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Schließen"></button>
            </div>
            <form method="POST" id="rabattEditForm" action="#">
                <div class="modal-body">
                    <div>
                        <label for="editRabattId" class="form-label mt-2">ID</label>
                        <input type="text" class="form-control disabledInput" id="editRabattId" name="id" required>
                    </div>
                    <div>
                        <label for="editRabattCode" class="form-label mt-2">Rabatt Code</label>
                        <input type="text" class="form-control" id="editRabattCode" name="rabattCode" required>
                    </div>
                    <div>
                        <label for="editRabatt" class="form-label mt-2">Rabatt (in %)</label>
                        <input type="text" class="form-control" id="editRabatt" name="rabatt" required>
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