<?php

namespace App\components\kundenverwaltung\account;

use App\datenbank\Entitaeten\Adresse;
use App\datenbank\Entitaeten\Kunde;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\KundeRepository;
use App\utils\BundeslandFetcher;
use Doctrine\ORM\EntityManager;

class AccountLogic
{
    private EntityManager $entityManager;
    public string $errorMessage = "";

    public function __construct()
    {
        $entityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $entityManagerFactory->createEntityManager();
    }

    public function getFullAddress(Adresse $adresse): string
    {
        $zusatz = "";
        if ($adresse->getZusatz() != null)
        {
            $zusatz = " (".$adresse->getZusatz().")";
        }

        return $adresse->getStrassenname()." ".$adresse->getHausnummer().", ".$adresse->getPLZ()." ".$adresse->getStadt().$zusatz;
    }

    public function getAccountByUsername(string $nutzername): Kunde|bool
    {
        $kundeRepository = new KundeRepository($this->entityManager);
        return $kundeRepository->findByUsername($nutzername);
    }

    public function updateAdresse(string $nutzername, string $Strassenname, string $Hausnummer, ?string $Zusatz, string $PLZ, string $Stadt): bool
    {
        $kunde = $this->getAccountByUsername($nutzername);
        if (!$kunde) {
            $this->errorMessage = "Unerwarteter Fehler: Kunde nicht gefunden!";
            return false;
        }

        $adresse = $kunde->getAdresse();
        $adresse->setStrassenname($Strassenname);
        $adresse->setHausnummer($Hausnummer);
        $adresse->setZusatz($Zusatz);
        $adresse->setPLZ($PLZ);
        $adresse->setStadt($Stadt);

        $bundesland = BundeslandFetcher::getBundesland($PLZ);
        if (!$bundesland) {
            $this->errorMessage = "Unerwarteter Fehler: Bundesland API nicht gefunden!";
            return false;
        }

        $adresse->setBundesland($bundesland);

        $kundeRepository = new KundeRepository($this->entityManager);
        return $kundeRepository->save($kunde);
    }
}