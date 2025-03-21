<?php
$kunden = $kunden ?? null;
?>

<h3 class="mb-3 mt-3">Nachricht senden</h3>
<form action="#" id="messageForm" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="kundenAuswahl" class="form-label">Kunde auswählen</label>
        <select class="form-select" id="kundenAuswahl" name="kunde" required
                onchange="onKundenSelectChange()">
            <option value="" style="color: #6c757d" selected disabled>Wähle einen Kunden...</option>
            <?php foreach ($kunden as $kunde): ?>
                <option value=<?= $kunde->getId() ?>>
                    <?= $kunde->getVorname()." ".$kunde->getNachname() ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="messageText" class="form-label">Nachricht</label>
        <textarea class="form-control" id="messageText" name="message" rows="4" required placeholder="Deine Nachricht hier..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Nachricht senden</button>
</form>