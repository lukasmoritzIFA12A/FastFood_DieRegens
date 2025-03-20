<div class="tab-pane fade" id="menu" role="tabpanel" aria-labelledby="menu-tab">
    <h3 class="mb-3">Menü hinzufügen</h3>
    <form action="#" id="menueForm" method="post" enctype="multipart/form-data">
        <!-- Menü Bild -->
        <div class="mb-3">
            <label for="menuImage" class="form-label">Menü Bild hochladen</label>
            <input type="file" class="form-control" id="menuImage" name="bild" required>
        </div>
        <!-- Menü Titel -->
        <div class="mb-3">
            <label for="menuTitle" class="form-label">Titel des Menüs</label>
            <input type="text" class="form-control" id="menuTitle" name="titel" required>
        </div>
        <!-- Menü Beschreibung -->
        <div class="mb-3">
            <label for="menuDescription" class="form-label">Beschreibung</label>
            <textarea class="form-control" id="menuDescription" name="beschreibung" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="menuPrice" class="form-label">Preis</label>
            <input type="number" step="0.01" min="0" class="form-control" id="menuPrice" name="preis"
                   required>
        </div>
        <!-- Produkte -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label mb-0">Produkte</label>
                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addProductModal" onclick="clearProductSearchInput()"
                        style="display: inline-flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Hinzufügen
                </button>
            </div>
            <div class="table-responsive scroll-table">
                <table class="table table-bordered">
                    <tbody id="addedProductsList">
                    <tr id="noProductsMessage">
                        <td class="text-center text-muted">Es wurden noch keine Produkte hinzugefügt.</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <input type="hidden" name="produkte" id="produkteInput">
        </div>
        <button type="submit" class="btn btn-primary w-100">Menü hinzufügen</button>
    </form>
</div>