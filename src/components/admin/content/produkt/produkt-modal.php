<div class="modal fade" id="produktModal" tabindex="-1" aria-labelledby="produktAnpassen"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="produktAnpassen">Produkt bearbeiten</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Schließen"></button>
            </div>
            <form method="POST" id="produktEditForm" action="#">
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

<!-- Modal: Zutatauswahl für Produkt hinzufügen -->
<div class="modal fade" id="addZutatModal" tabindex="-1" aria-labelledby="addZutatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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