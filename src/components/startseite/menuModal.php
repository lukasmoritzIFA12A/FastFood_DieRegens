<div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="menuModalLabel">Menü Titel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Menü-Details -->
                <div class="row align-items-center">
                    <div class="col-md-6 text-center">
                        <img id="menuImage" class="img-fluid rounded shadow-sm" alt="Menü Bild" onerror="this.src='../../../assets/img/noimage.jpg';">
                    </div>
                    <div class="col-md-6">
                        <p class="fw-bold fs-5">Preis: <span id="menuPrice" class="text-success"></span></p>
                        <p class="fw-semibold">Menübeschreibung:</p>
                        <p id="menuDescription" class="text-muted"></p>
                    </div>
                </div>

                <!-- Produktliste ähnlich wie Energiewerte -->
                <div class="text-center mt-4">
                    <button id="menueProductListBtn" class="btn btn-info" data-bs-toggle="collapse" data-bs-target="#menueProductListCollapse" aria-expanded="false" aria-controls="menueProductListCollapse">
                        Produkte anzeigen
                    </button>
                </div>
                <div class="collapse mt-3" id="menueProductListCollapse">
                    <div class="card card-body">
                        <ul id="menueProductList" class="list-group list-group-flush overflow-auto" style="max-height: 20vh;">
                            <!-- Produkt-Einträge werden per JavaScript eingefügt -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                <button type="button" class="btn btn-success">In den Warenkorb</button>
            </div>
        </div>
    </div>
</div>