<?php
$account = $account ?? null;
$menues = $menues ?? [];
$produkte = $produkte ?? [];
$warenkorbLogic = $warenkorbLogic ?? null;
?>

<!-- Bestellung Bestätigt Modal -->
<div class="modal fade" id="bestellungErfolgreichModal" tabindex="-1" aria-labelledby="bestellungErfolgreichModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="bestellungErfolgreichModalLabel">Bestellung Erfolgreich!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Schließen"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <!-- Großes Check-Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72" fill="currentColor"
                         class="bi bi-check-circle-fill text-white bg-success rounded-circle p-2" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 10.03a.75.75 0 0 0 1.07 0L11.03 6a.75.75 0 1 0-1.06-1.06L7.5 8.44 6.03 6.97a.75.75 0 1 0-1.06 1.06l2 2z"/>
                    </svg>
                </div>
                <h4 class="text-center mb-3">Vielen Dank für Ihre Bestellung, <?= $account->getVorname() ?>!</h4>
                <p class="text-center">Ihre Bestellung wird in Kürze bearbeitet.</p>
                <p class="text-center">Sie können den Verlauf der Bestellung in Ihrem Bestellverlauf einsehen.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="../startseite/startseite.php" class="btn btn-primary btn-lg">Zur Startseite</a>
            </div>
        </div>
    </div>
</div>