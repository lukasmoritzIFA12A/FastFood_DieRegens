<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Menue;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class MenueRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Menue::class);
    }

    public function getTopMenue(): Menue|bool
    {
        $bestellungRepository = new BestellungRepository($this->getEntityManager());
        $bestellungen = $bestellungRepository->getAll();
    //Falls keine Bestellungen gefunden wurden, soll statt dem Top Menü, ein Random Menü angezeigt werden
        if (!$bestellungen) {
            return $this->getRandomMenue();
        }

        $menueCount = [];

        foreach ($bestellungen as $bestellung) {
            foreach ($bestellung->getMenues() as $menue) {
                $menueId = $menue->getId();
                $menueCount[$menueId] = ($menueCount[$menueId] ?? 0) + 1;
            }
        }

        // Meistgekauftes Menü ermitteln
        arsort($menueCount); // Sortiert absteigend nach Anzahl
        $topMenueId = array_key_first($menueCount); // Holt das erste (häufigste) Menü

        if (!$topMenueId) {
            return $this->getRandomMenue();
        }

        return $this->getEntityManager()->getRepository(Menue::class)->find($topMenueId);
    }

    public function getRandomMenue(): Menue|bool
    {
        $menues = $this->getEntityManager()->getRepository(Menue::class)->findAll();
        $availableMenues = array_filter($menues, function($menue) {
            return !$menue->isAusverkauft();
        });
        return !empty($availableMenues) ? $availableMenues[array_rand($availableMenues)] : false;
    }
}