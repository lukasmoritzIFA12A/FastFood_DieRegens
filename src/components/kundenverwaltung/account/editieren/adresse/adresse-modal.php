<div class="modal fade" id="editAdresse" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adresse bearbeiten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="adresseForm" action="#">
                <div class="modal-body">
                    <div class="d-flex gap-5">
                        <div>
                            <label for="newStreet" class="form-label">Straße</label>
                            <input type="text" class="form-control" id="newStreet" name="newStreet">
                        </div>
                        <div>
                            <label for="newNumber" class="form-label">Haus-Nr.</label>
                            <input type="text" class="form-control" id="newNumber" name="newNumber">
                        </div>
                    </div>

                    <div class="d-flex gap-5">
                        <div>
                            <label for="newPostalCode" class="form-label mt-2">PLZ</label>
                            <input type="text" class="form-control" id="newPostalCode" name="newPostalCode">
                        </div>
                        <div>
                            <label for="newCity" class="form-label mt-2">Stadt</label>
                            <input type="text" class="form-control" id="newCity" name="newCity">
                        </div>
                    </div>

                    <div>
                        <label for="newZusatz" class="form-label mt-2">Zusatz</label>
                        <input type="text" class="form-control" id="newZusatz" name="newZusatz">
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