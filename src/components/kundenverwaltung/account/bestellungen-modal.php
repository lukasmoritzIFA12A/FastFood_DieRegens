<?php
$bestellungen = $bestellungen ?? null;
$accountLogic = $accountLogic ?? null;
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
                                            Datum: <?= $bestellungen[$i]->getBestellungDatum()->format("d.m.Y - H:i") . " Uhr" ?></p>
                                        <p class="mb-0">
                                            Zahlungsart: <?= $bestellungen[$i]->getZahlungsart()->getArt() ?></p>
                                    </div>
                                    <span class="badge"
                                          style="background-color: <?= $bestellungen[$i]->getBestellstatus()->getFarbe() ?>"><?= $bestellungen[$i]->getBestellstatus()->getStatus() ?></span>
                                </div>
                                <div class="collapse" id=<?= "orderDetails$i" ?>>
                                    <div class="mt-2">
                                        <?php if (!$bestellungen[$i]->getMenues()->isEmpty()): ?>
                                            <strong>Menüs:</strong>
                                            <ul>
                                                <?php foreach ($bestellungen[$i]->getMenues() as $menue): ?>
                                                    <li><?= $menue->getTitel() ?> - <?= $menue->getPreis() ?> €</li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if (!$bestellungen[$i]->getProdukte()->isEmpty()): ?>
                                            <strong>Produkte:</strong>
                                            <ul>
                                                <?php foreach ($bestellungen[$i]->getProdukte() as $produkt): ?>
                                                    <li><?= $produkt->getTitel() ?> - <?= $produkt->getPreis() ?> €</li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>

                                        <?php if ($bestellungen[$i]->getProdukte()->isEmpty() && $bestellungen[$i]->getMenues()->isEmpty()): ?>
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
