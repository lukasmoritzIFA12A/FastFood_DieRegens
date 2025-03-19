<?php
$bestellungen = $bestellungen ?? null;
$accountLogic = $accountLogic ?? null;

if ($bestellungen) {
    $bestellungen = array_reverse($bestellungen);
}
?>

<div class="modal fade" id="orderHistory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bestellverlauf</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bestellhistorie">
                <ul class="list-group">
                    <?php if (empty($bestellungen)): ?>
                        <li class="list-group-item text-center">Noch keine Bestellungen getätigt 😥</li>
                    <?php else: ?>
                        <?php for ($i = 0; $i < count($bestellungen); $i++): ?>
                            <li class="list-group-item list-group-item-action" data-bs-toggle="collapse"
                                data-bs-target=<?= "#orderDetails$i" ?>>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Bestellung #<?= $bestellungen[$i]->getId() ?>
                                            - <?= $accountLogic->calculatePrice($bestellungen[$i]) ?> €</strong>
                                        <p class="mb-0">
                                            Datum: <?= $bestellungen[$i]->getBestellungDatum() . " Uhr" ?></p>

                                        <?php if(!empty($bestellungen[$i]->getZahlungsart())): ?>
                                            <p class="mb-0">
                                                Zahlungsart: <?= $bestellungen[$i]->getZahlungsart()->getArt() ?></p>
                                        <?php else: ?>
                                            <p class="mb-0">
                                                Zahlungsart: Unbekannt</p>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($bestellungen[$i]->getBestellstatus() !== null): ?>
                                        <span class="badge"
                                              style="background-color: <?= $bestellungen[$i]->getBestellstatus()->getFarbe() ?>"><?= $bestellungen[$i]->getBestellstatus()->getStatus() ?></span>
                                    <?php else: ?>
                                        <span class="badge"
                                              style="background-color: #B0B0B0">Bestellt</span>
                                    <?php endif; ?>
                                </div>
                                <div class="collapse" id=<?= "orderDetails$i" ?>>
                                    <div class="mt-2">
                                        <?php if (!$bestellungen[$i]->getBestellungmenues()->isEmpty()): ?>
                                            <strong>Menüs:</strong>
                                            <ul>
                                                <?php foreach ($bestellungen[$i]->getBestellungmenues() as $bestellungmenue): ?>
                                                    <li><?= $bestellungmenue->getMenue()->getTitel() ?>
                                                        (<?= $bestellungmenue->getMenge() ?>x)
                                                        - <?= $bestellungmenue->getMenue()->getPreis() ?> €
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!$bestellungen[$i]->getBestellungprodukte()->isEmpty()): ?>
                                            <strong>Produkte:</strong>
                                            <ul>
                                                <?php foreach ($bestellungen[$i]->getBestellungprodukte() as $bestellungprodukt): ?>
                                                    <li><?= $bestellungprodukt->getProdukt()->getTitel() ?>
                                                        (<?= $bestellungprodukt->getMenge() ?>x)
                                                        - <?= $bestellungprodukt->getProdukt()->getPreis() ?> €
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if ($bestellungen[$i]->getBestellungprodukte()->isEmpty() && $bestellungen[$i]->getBestellungmenues()->isEmpty()): ?>
                                            <strong style="color: red">Unerwarteter Fehler: Keine Produkte und Menüs in
                                                dieser Bestellung!</strong>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </li>
                        <?php endfor; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
            </div>
        </div>
    </div>
</div>
