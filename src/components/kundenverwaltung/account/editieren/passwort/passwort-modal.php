<div class="modal fade" id="changePassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Passwort ändern</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="passwortForm" action="#">
                <div class="modal-body">
                    <label for="oldPassword" class="form-label">Altes Passwort</label>
                    <input type="password" class="form-control mb-2" id="oldPassword" name="oldPassword" placeholder="Altes Passwort">
                    <label for="newPassword" class="form-label">Neues Passwort</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Neues Passwort">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Passwort ändern</button>
                </div>
            </form>
        </div>
    </div>
</div>