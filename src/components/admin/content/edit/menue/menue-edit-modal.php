<div class="modal fade" id="menueModal" tabindex="-1" aria-labelledby="menueAnpassen"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="menueAnpassen">Menü bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Schließen"></button>
            </div>
            <form method="POST" id="menueEditForm" action="#">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="menueid" class="form-label mt-2">ID</label>
                        <input type="text" class="form-control disabledInput" id="menueid" name="id" required>
                    </div>
                    <!-- Menü Bild -->
                    <label for="menueBild" class="form-label">Menü Bild hochladen</label>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="menueBild" name="bild" onchange="showImage(event, 'menuImageLoaded')">
                    </div>
                    <div class="mb-3">
                        <img alt="Menü Bild"
                             class="img-thumbnail" id="menuImageLoaded" width="100" height="100"
                             onerror="this.src='../../../assets/img/noimage.jpg';">
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
                                    data-bs-target="#addEditMenueProductModal" onclick="openEditMenueProductModal()"
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
                                <tbody id="addedEditMenueProductsList">
                                <tr id="noEditMenueProductsMessage">
                                    <td class="text-center text-muted">Es wurden noch keine Produkte hinzugefügt.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="produkte" id="editMenueProdukteInput">
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

<!-- Modal: Produktauswahl für Edit Menü hinzufügen -->
<div class="modal fade" id="addEditMenueProductModal" tabindex="-1" aria-labelledby="addEditMenueProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditMenueProductModalLabel">Produkt hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="productSearch" class="form-control" placeholder="Produkt suchen..."
                           oninput="filterProducts()">
                </div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover" id="productListTable">
                        <tbody id="productList">
                        <?php if (empty($produkte)): ?>
                            <tr>
                                <td class="text-center text-muted">Es wurden keine Produkte gefunden.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($produkte as $produkt): ?>
                            <tr>
                                <td class="product-name"><?= $produkt->getTitel() ?></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="addProductToEditMenu('<?= $produkt->getTitel() ?>', '<?= $produkt->getId() ?>')">
                                        Hinzufügen
                                        <span id="<?= $produkt->getTitel() ?>Edit" class="ms-2 d-none">✓</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>