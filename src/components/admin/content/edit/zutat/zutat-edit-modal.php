<div class="modal fade" id="zutatModal" tabindex="-1" aria-labelledby="zutatAnpassen"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="zutatAnpassen">Zutat bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Schließen"></button>
            </div>
            <form method="POST" id="zutatEditForm" action="#">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="zutatid" class="form-label mt-2">ID</label>
                        <input type="text" class="form-control disabledInput" id="zutatid" name="id" required>
                    </div>

                    <div class="mb-3">
                        <label for="zutatName" class="form-label">Zutat</label>
                        <input type="text" class="form-control" id="zutatName" name="zutat">
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