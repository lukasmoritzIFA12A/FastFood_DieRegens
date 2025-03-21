<div class="tab-pane fade" id="zahlungsart" role="tabpanel" aria-labelledby="zahlungsart-tab">
    <h3 class="mb-3">Zahlungsart hinzufügen</h3>
    <form action="#" id="zahlungsartForm" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="zahlungsartIcon" class="form-label">Zahlungsart Icon hochladen</label>
            <input type="file" class="form-control" id="zahlungsartIcon" name="bild" required>
        </div>
        <div class="mb-3">
            <label for="zahlungsartArt" class="form-label">Titel</label>
            <input type="text" class="form-control" id="zahlungsartArt" name="art" required>
        </div>

        <button type="submit" class="btn btn-primary">Zahlungsart hinzufügen</button>
    </form>
</div>