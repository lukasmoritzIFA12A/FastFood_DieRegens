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
                    <div class="mb-3">
                        <label for="produktId" class="form-label mt-2">ID</label>
                        <input type="text" class="form-control disabledInput" id="produktId" name="id" required>
                    </div>
                    <!-- Produkt Bild -->
                    <label for="produktBild" class="form-label">Produkt Bild hochladen</label>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="produktBild" name="bild" onchange="showImage(event, 'produktImageLoaded')">
                    </div>
                    <div class="mb-3">
                        <img alt="Produkt Bild"
                             class="img-thumbnail" id="produktImageLoaded" width="100" height="100"
                             onerror="this.src='../../../assets/img/noimage.jpg';">
                    </div>

                    <!-- Produkt Titel -->
                    <div class="mb-3">
                        <label for="produktTitle" class="form-label">Titel des Menüs</label>
                        <input type="text" class="form-control" id="produktTitle" name="titel" required>
                    </div>
                    <!-- Produkt Beschreibung -->
                    <div class="mb-3">
                        <label for="produktDescription" class="form-label">Beschreibung</label>
                        <textarea class="form-control" id="produktDescription" name="beschreibung" rows="3"></textarea>
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
                                    data-bs-target="#addEditProduktZutatModal" onclick="openEditProductZutatModal()" style="display: inline-flex; align-items: center; justify-content: center;">
                                <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                                Hinzufügen
                            </button>
                        </div>
                        <div class="table-responsive scroll-table">
                            <table class="table table-bordered">
                                <tbody id="addedEditProduktZutatenList">
                                <tr id="noEditProduktZutatenMessage">
                                    <td class="text-center text-muted">Es wurden noch keine Zutaten hinzugefügt.</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="zutaten" id="editProduktZutatenInput">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Energiewerte</label>
                        <br>
                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addEditProduktEnergiewerteModal"
                                id="editProduktEnergiewertAdminAddButton"
                                onclick="openEditProductEnergiewerteModal()"
                                style="display: inline-flex; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            Hinzufügen
                        </button>

                        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#addEditProduktEnergiewerteModal"
                                id="editProduktEnergiewertAdminEditButton"
                                onclick="openEditProductEnergiewerteModal()"
                                style="display: none; align-items: center; justify-content: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 5px; margin-bottom: 2.5px" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/>
                            </svg>
                            Ändern
                        </button>
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

<!-- Modal: Zutatauswahl für EditProdukt hinzufügen -->
<div class="modal fade" id="addEditProduktZutatModal" tabindex="-1" aria-labelledby="addEditProduktZutatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEditProduktZutatModalLabel">Zutat hinzufügen</h5>
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
                                            onclick="addZutatToEditProdukt('<?= $zutat->getZutatName() ?>', '<?= $zutat->getId() ?>')">
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