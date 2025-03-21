<!-- Modal: Produktauswahl für Menü hinzufügen -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Produkt hinzufügen</h5>
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
                                            onclick="addProductToMenu('<?= $produkt->getTitel() ?>', '<?= $produkt->getId() ?>')">
                                        Hinzufügen
                                        <span id="<?= $produkt->getTitel() ?>Add" class="ms-2 d-none">✓</span>
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