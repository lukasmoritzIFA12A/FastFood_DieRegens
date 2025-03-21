<!-- Modal: Zutatauswahl für Produkt hinzufügen -->
<div class="modal fade" id="addZutatModal" tabindex="-1" aria-labelledby="addZutatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addZutatModalLabel">Zutat hinzufügen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="zutatSearch" class="form-control" placeholder="Zutat suchen..."
                           oninput="filterZutaten()">
                </div>
                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                    <table class="table table-hover" id="zutatListTable">
                        <tbody id="zutatList">
                        <?php if (empty($zutaten)): ?>
                            <tr>
                                <td class="text-center text-muted">Es wurden keine Zutaten gefunden.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($zutaten as $zutat): ?>
                            <tr>
                                <td class="zutat-name"><?= $zutat->getZutatName() ?></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-success btn-sm"
                                            onclick="addZutatToProdukt('<?= $zutat->getZutatName() ?>', '<?= $zutat->getId() ?>')">
                                        Hinzufügen
                                        <span id="<?= $zutat->getZutatName() ?>Add" class="ms-2 d-none">✓</span>
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