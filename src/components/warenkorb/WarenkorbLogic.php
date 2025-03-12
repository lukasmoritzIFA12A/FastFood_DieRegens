<?php

namespace App\components\warenkorb;

use App\datenbank\Entitaeten\Kunde;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\KundeRepository;
use App\datenbank\Repositories\MenueRepository;
use App\datenbank\Repositories\ProduktRepository;
use App\datenbank\Repositories\RabattRepository;
use App\datenbank\Repositories\ZahlungsartRepository;
use Doctrine\ORM\EntityManager;

class WarenkorbLogic
{
    private EntityManager $entityManager;
    public string $errorMessage = "";

    public function __construct()
    {
        $entityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $entityManagerFactory->createEntityManager();
    }

    public function getEingeloggterKunde($loginName): Kunde|bool
    {
        $kundeRepository = new KundeRepository($this->entityManager);
        return $kundeRepository->findByUsername($loginName);
    }

    public function getFormattedLieferAddress(Kunde $kunde): string
    {
        $adresse = $kunde->getAdresse();

        $zusatz = "";
        if ($adresse->getZusatz() != null) {
            $zusatz = " (" . $adresse->getZusatz() . ")";
        }

        return $adresse->getStrassenname()
            . " " . $adresse->getHausnummer()
            . " " . $zusatz
            . "<br>" . $adresse->getPLZ()
            . " " . $adresse->getStadt()
            . "<br>" . $kunde->getVorname()
            . " " . $kunde->getNachname()
            . "<br>" . $kunde->getTelefonnummer();
    }

    public function getRabatt(string $rabattcode): string|bool
    {
        $rabattRepository = new RabattRepository($this->entityManager);
        $rabatt = $rabattRepository->getRabattByCode($rabattcode);
        if (!$rabatt) {
            $this->errorMessage = "Rabatt Code existiert nicht!";
            return false;
        }
        $this->errorMessage = "";
        return $rabatt->getMinderung();
    }

    public function getAllZahlungsarten(): array
    {
        $zahlungsartRepository = new ZahlungsArtRepository($this->entityManager);
        return $zahlungsartRepository->findAll();
    }

    public function getAllProdukteByIds(array $produktIds): array
    {
        $produkte = [];

        $produktRepository = new ProduktRepository($this->entityManager);
        foreach ($produktIds as $produktId) {
            $produkt = $produktRepository->find($produktId);
            if (!$produkt) {
                continue;
            }
            $produkte[] = $produkt;
        }

        return $produkte;
    }

    public function getAllMenuesByIds(array $menueIds): array
    {
        $menues = [];

        $menueRepository = new MenueRepository($this->entityManager);
        foreach ($menueIds as $menueId) {
            $menue = $menueRepository->find($menueId);
            if (!$menue) {
                continue;
            }
            $menues[] = $menue;
        }

        return $menues;
    }
}