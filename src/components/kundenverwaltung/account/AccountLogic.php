<?php

namespace App\components\kundenverwaltung\account;

use App\datenbank\Entitaeten\Adresse;
use App\datenbank\Entitaeten\Bestellung;
use App\datenbank\Entitaeten\Kunde;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\BestellungRepository;
use App\datenbank\Repositories\KundeRepository;
use App\utils\BundeslandFetcher;
use App\utils\Number;
use App\validation\PasswortHash;
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
        if ($adresse->getZusatz() != null) {
            $zusatz = " (" . $adresse->getZusatz() . ")";
        }

        return $adresse->getStrassenname() . " " . $adresse->getHausnummer() . ", " . $adresse->getPLZ() . " " . $adresse->getStadt() . $zusatz;
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

    public function updateBenutzername(string $nutzername, string $newBenutzername): bool
    {
        $kunde = $this->getAccountByUsername($nutzername);
        if (!$kunde) {
            $this->errorMessage = "Unerwarteter Fehler: Kunde nicht gefunden!";
            return false;
        }

        if ($this->getAccountByUsername($newBenutzername)) {
            $this->errorMessage = "Benutzername ist bereits vergeben!";
            return false;
        }

        $login = $kunde->getLogin();
        $login->setNutzername($newBenutzername);
        $kundeRepository = new KundeRepository($this->entityManager);
        return $kundeRepository->save($kunde);
    }

    public function updateNachname(string $nutzername, string $newNachname): bool
    {
        $kunde = $this->getAccountByUsername($nutzername);
        if (!$kunde) {
            $this->errorMessage = "Unerwarteter Fehler: Kunde nicht gefunden!";
            return false;
        }

        $kunde->setNachname($newNachname);
        $kundeRepository = new KundeRepository($this->entityManager);
        return $kundeRepository->save($kunde);
    }

    public function updateTelefon(string $nutzername, ?string $newTelefon): bool
    {
        $kunde = $this->getAccountByUsername($nutzername);
        if (!$kunde) {
            $this->errorMessage = "Unerwarteter Fehler: Kunde nicht gefunden!";
            return false;
        }

        $kunde->setTelefonnummer($newTelefon);
        $kundeRepository = new KundeRepository($this->entityManager);
        return $kundeRepository->save($kunde);
    }

    public function updateVorname(string $nutzername, string $newVorname): bool
    {
        $kunde = $this->getAccountByUsername($nutzername);
        if (!$kunde) {
            $this->errorMessage = "Unerwarteter Fehler: Kunde nicht gefunden!";
            return false;
        }

        $kunde->setVorname($newVorname);
        $kundeRepository = new KundeRepository($this->entityManager);
        return $kundeRepository->save($kunde);
    }

    public function updatePasswort(string $nutzername, string $altesPasswort, string $neuesPasswort): bool
    {
        $kunde = $this->getAccountByUsername($nutzername);
        if (!$kunde) {
            $this->errorMessage = "Unerwarteter Fehler: Kunde nicht gefunden!";
            return false;
        }

        if (PasswortHash::verifyPassword($altesPasswort, $kunde->getLogin()->getPasswort())) {
            $kunde->getLogin()->setPasswort(PasswortHash::hashPassword($neuesPasswort));
            $kundeRepository = new KundeRepository($this->entityManager);
            return $kundeRepository->save($kunde);
        } else {
            $this->errorMessage = "Altes Passwort ist falsch!";
            return false;
        }
    }

    public function getBestellungen(string $nutzername): bool|array
    {
        $kunde = $this->getAccountByUsername($nutzername);
        if (!$kunde) {
            $this->errorMessage = "Unerwarteter Fehler: Kunde nicht gefunden!";
            return false;
        }

        $bestellungRepository = new BestellungRepository($this->entityManager);
        return $bestellungRepository->getBestellungenByKunde($kunde);
    }

    public function calculatePrice(Bestellung $bestellung): string
    {
        $summe = "0.00";

        foreach ($bestellung->getBestellungprodukte() as $bestellungprodukte) {
            $preis = Number::unformatPreis($bestellungprodukte->getProdukt()->getPreis());
            $preis = Number::multiplierPreis($preis, $bestellungprodukte->getMenge());
            $summe = Number::summePreis($summe, $preis);
        }

        foreach ($bestellung->getBestellungmenues() as $bestellungmenue) {
            $preis = Number::unformatPreis($bestellungmenue->getMenue()->getPreis());
            $preis = Number::multiplierPreis($preis, $bestellungmenue->getMenge());
            $summe = Number::summePreis($summe, $preis);
        }

        return Number::reformatPreis($summe);
    }
}