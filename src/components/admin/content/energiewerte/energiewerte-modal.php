<div class="modal fade" id="addEnergiewerteModal" tabindex="-1" aria-labelledby="addEnergiewerteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" id="energiewerteForm" method="post">
                <div class="modal-header">
                    <h3 class="mb-3">Energiewerte hinzufügen</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Schließen"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nvPortionSize" class="form-label">Portionsgröße</label>
                        <input type="number" min="0" class="form-control" id="nvPortionSize" name="portionSize" required>
                    </div>
                    <div class="mb-3">
                        <label for="nvCalories" class="form-label">Kalorien (kcal)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="nvCalories" name="kalorien" required>
                    </div>
                    <div class="mb-3">
                        <label for="nvFat" class="form-label">Fett (g)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="nvFat" name="fett" required>
                    </div>
                    <div class="mb-3">
                        <label for="nvCarbohydrates" class="form-label">Kohlenhydrate (g)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="nvCarbohydrates"
                               name="kohlenhydrate" required>
                    </div>
                    <div class="mb-3">
                        <label for="nvSugar" class="form-label">Zucker (g)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="nvSugar" name="zucker" required>
                    </div>
                    <div class="mb-3">
                        <label for="nvProtein" class="form-label">Eiweiß (g)</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="nvProtein" name="eiweiss" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Energiewerte hinzufügen</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                </div>
            </form>
        </div>
    </div>
</div>