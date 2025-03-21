<div class="tab-pane fade" id="rabatt" role="tabpanel" aria-labelledby="rabatt-tab">
    <h3 class="mb-3">Rabatt hinzufügen</h3>
    <form action="#" id="rabattForm" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="rabattCode" class="form-label">Rabatt Code</label>
            <input type="text" class="form-control" id="rabattCode" name="rabattCode" required>
        </div>

        <div class="mb-3">
            <label for="rabatt" class="form-label">Rabatt (in %)</label>
            <input type="number" class="form-control" id="rabatt" name="rabatt" required>
        </div>

        <button type="submit" class="btn btn-primary">Rabatt hinzufügen</button>
    </form>
</div>