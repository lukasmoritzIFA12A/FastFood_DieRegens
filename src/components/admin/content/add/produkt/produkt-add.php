<div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
    <h3 class="mb-3">Produkte hinzufügen</h3>
    <form action="#" id="produktForm" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="productImage" class="form-label">Produkt Bild hochladen</label>
            <input type="file" class="form-control" id="productImage" name="bild" required>
        </div>
        <div class="mb-3">
            <label for="productTitle" class="form-label">Titel</label>
            <input type="text" class="form-control" id="productTitle" name="titel" required>
        </div>
        <div class="mb-3">
            <label for="productDescription" class="form-label">Beschreibung</label>
            <textarea class="form-control" id="productDescription" name="beschreibung" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="productPrice" class="form-label">Preis</label>
            <input type="number" step="0.01" min="0" class="form-control" id="productPrice" name="preis"
                   required>
        </div>
        <div class="mb-3 form-check">
            <input class="form-check-input" type="checkbox" value="false" id="productStock" name="ausverkauft">
            <label class="form-check-label" for="productStock">
                Ausverkauft
            </label>
        </div>
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <label class="form-label mb-0">Zutaten</label>
                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addZutatModal" onclick="clearZutatSearchInput()" style="display: inline-flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                    Hinzufügen
                </button>
            </div>
            <div class="table-responsive scroll-table">
                <table class="table table-bordered">
                    <tbody id="addedZutatenList">
                    <tr id="noZutatenMessage">
                        <td class="text-center text-muted">Es wurden noch keine Zutaten hinzugefügt.</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <input type="hidden" name="zutaten" id="zutatenInput">
        </div>

        <div class="mb-3">
            <label class="form-label">Energiewerte</label>
            <br>
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addEnergiewerteModal"
                    id="energiewertAdminAddButton"
                    style="display: inline-flex; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
                Hinzufügen
            </button>

            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addEnergiewerteModal"
                    id="energiewertAdminEditButton"
                    style="display: none; align-items: center; justify-content: center;">
                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px; margin-bottom: 2.5px" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                </svg>
                Ändern
            </button>
        </div>

        <button type="submit" class="btn btn-primary">Produkt hinzufügen</button>
    </form>
</div>