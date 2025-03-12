<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="productModalLabel">Produkt Titel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center">
                    <!-- Produktbild -->
                    <div class="col-md-6 text-center">
                        <img id="productImage"
                             class="img-fluid rounded shadow-sm"
                             alt="Produkt Bild"
                             onerror="this.src='../../../assets/img/noimage.jpg';">
                    </div>
                    <!-- Produktdetails -->
                    <div class="col-md-6">
                        <p class="fw-bold fs-5">Preis: <span id="productPrice" class="text-success"></span></p>

                        <p class="fw-semibold">Produktbeschreibung:</p>
                        <p id="productDescription" class="text-muted"></p>

                        <p class="fw-semibold">Zutaten:</p>
                        <p id="productIngredients" class="text-muted"></p>
                    </div>
                </div>

                <!-- Button für Energiewerte -->
                <div class="text-center mt-4">
                    <button id="energyValuesBtn"
                            class="btn btn-info"
                            data-bs-toggle="collapse"
                            data-bs-target="#energyValuesCollapse"
                            aria-expanded="false"
                            aria-controls="energyValuesCollapse">
                        Nährwerte anzeigen
                    </button>
                </div>

                <!-- Aufklappbarer Bereich für Energiewerte -->
                <div class="collapse mt-3" id="energyValuesCollapse">
                    <div class="card card-body">
                        <ul class="list-unstyled">
                            <li><strong>Portionsgröße:</strong> <span id="portionSize"></span></li>
                            <li><strong>Kalorien:</strong> <span id="calories"></span> kcal</li>
                            <li><strong>Fett:</strong> <span id="fat"></span> g</li>
                            <li><strong>Kohlenhydrate:</strong> <span id="carbs"></span> g</li>
                            <li><strong>Zucker:</strong> <span id="sugar"></span>g</li>
                            <li><strong>Eiweiß:</strong> <span id="protein"></span>g</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                <button type="button" id="warenkorbProdukt" class="btn btn-success">In den Warenkorb</button>
            </div>
        </div>
    </div>
</div>