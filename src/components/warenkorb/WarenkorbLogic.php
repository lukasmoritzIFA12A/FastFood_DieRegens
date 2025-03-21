<?php

namespace App\components\warenkorb;

use App\datenbank\Entitaeten\Bestellung;
use App\datenbank\Entitaeten\BestellungMenue;
use App\datenbank\Entitaeten\BestellungProdukt;
use App\datenbank\Entitaeten\Kunde;
use App\datenbank\Entitaeten\Menue;
use App\datenbank\Entitaeten\Produkt;
use App\datenbank\Entitaeten\Rabatt;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\BestellungRepository;
use App\datenbank\Repositories\KundeRepository;
use App\datenbank\Repositories\MenueRepository;
use App\datenbank\Repositories\ProduktRepository;
use App\datenbank\Repositories\RabattRepository;
use App\datenbank\Repositories\ZahlungsartRepository;
use App\utils\Number;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['lieferadresseWasEdited'])) {
            if ($_SESSION['lieferadresseWasEdited'] === '1') {
                $kunde = $this->getSessionLieferKunde($kunde);
            }
        }

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

    public function getSessionLieferKunde(Kunde $kunde): Kunde
    {
        $kunde->getAdresse()->setStrassenname($_SESSION['newStreet']);
        $kunde->getAdresse()->setHausnummer($_SESSION['newNumber']);
        $kunde->getAdresse()->setPLZ($_SESSION['newPostalCode']);
        $kunde->getAdresse()->setStadt($_SESSION['newCity']);
        $kunde->getAdresse()->setZusatz($_SESSION['newZusatz']);

        $kunde->setVorname($_SESSION['newVorname']);
        $kunde->setNachname($_SESSION['newNachname']);
        $kunde->setTelefonnummer($_SESSION['newTelefonnummer']);
        return $kunde;
    }

    public function getRabatt(string $rabattcode): Rabatt|bool
    {
        $rabattRepository = new RabattRepository($this->entityManager);
        $rabatt = $rabattRepository->getRabattByCode($rabattcode);
        if (!$rabatt) {
            $this->errorMessage = "Rabatt Code existiert nicht!";
            return false;
        }
        $this->errorMessage = "";
        return $rabatt;
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

    public function getMenueById(string $menueId): Menue|bool
    {
        $menueRepository = new MenueRepository($this->entityManager);
        $menue = $menueRepository->find($menueId);
        if (!$menue) {
            $this->errorMessage = "Menue nicht gefunden!";
            return false;
        }
        return $menue;
    }

    public function getProduktById(string $produktId): Produkt|bool
    {
        $produktRepository = new ProduktRepository($this->entityManager);
        $produkt = $produktRepository->find($produktId);
        if (!$produkt) {
            $this->errorMessage = "Produkt nicht gefunden!";
            return false;
        }
        return $produkt;
    }

    public function getGesamtSumme(): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $gesamtSumme = Number::unformatPreis($this->getZwischenSumme());

        if (!empty($_SESSION['trinkgeld'])) {
            $trinkgeldPreis = $_SESSION['trinkgeld'];
            $gesamtSumme = Number::summePreis($gesamtSumme, $trinkgeldPreis);
        }

        return Number::reformatPreis($gesamtSumme);
    }

    public function isSelectedTrinkgeld($trinkgeld): bool
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['trinkgeld']) && isset($_SESSION['andereTrinkgeld'])) {
            if ($trinkgeld === "Andere") {
                if ($_SESSION['andereTrinkgeld'] === "1") {
                    return true;
                }
            }

            return $_SESSION['trinkgeld'] === $trinkgeld;
        }

        return false;
    }

    public function getAndereTrinkgeld(): string
    {
        if ($this->isSelectedTrinkgeld("Andere")) {
            return $_SESSION['trinkgeld'];
        }

        return "0.00";
    }

    public function getRabattProzent(): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['rabatt'])) {
            return $_SESSION['rabatt'];
        }

        return "0";
    }

    public function getRabattSumme(): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['rabatt'])) {
            $gesamtSumme = $this->getProduktMenuePreis();
            $rabattProzent = $_SESSION['rabatt'];

            $gesamtSumme = Number::prozentPreis($gesamtSumme, $rabattProzent);
            return Number::reformatPreis($gesamtSumme);
        }

        return "0,00";
    }

    public function getZwischenSumme(): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $gesamtSumme = $this->getProduktMenuePreis();

        if (!empty($_SESSION['rabatt'])) {
            $rabattProzent = $_SESSION['rabatt'];
            $zwischensumme = Number::prozentPreis($gesamtSumme, $rabattProzent);
            $gesamtSumme = Number::subtraktionPreis($gesamtSumme, $zwischensumme);
        }

        return Number::reformatPreis($gesamtSumme);
    }

    public function getProduktMenuePreis(): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $gesamtSumme = "0.00";

        $menues = $_SESSION['warenkorb']['menues'] ?? [];
        $produkte = $_SESSION['warenkorb']['produkte'] ?? [];

        foreach ($menues as $menueId => $count) {
            $menue = $this->getMenueById($menueId);
            if (!$menue) {
                continue;
            }
            $menuePreis = Number::unformatPreis($menue->getPreis());
            $menuePreisGesamt = Number::multiplierPreis($menuePreis, $count);
            $gesamtSumme = Number::summePreis($gesamtSumme, $menuePreisGesamt);
        }

        foreach ($produkte as $produktId => $count) {
            $produkt = $this->getProduktById($produktId);
            if (!$produkt) {
                continue;
            }
            $produktPreis = Number::unformatPreis($produkt->getPreis());
            $produktPreisGesamt = Number::multiplierPreis($produktPreis, $count);
            $gesamtSumme = Number::summePreis($gesamtSumme, $produktPreisGesamt);
        }
        return $gesamtSumme;
    }

    public function getTrinkgeldSumme(): string
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['trinkgeld'])) {
            return Number::reformatPreis($_SESSION['trinkgeld']);
        }

        return "0,00";
    }

    public function updateAllWarenkorb(): void
    {
        $this->updateRabatt();
    }

    public function updateRabatt(): void
    {
        if (!empty($_SESSION['rabattcode']) && !empty($_SESSION['rabatt'])) {
            $rabattcode = $_SESSION['rabattcode'];
            $rabatt = $_SESSION['rabatt'];

            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    setRabattInputAsDeactivated('$rabattcode', '$rabatt');
                });
            </script>";
        }
    }

    public function isSelectedZahlungsart($zahlungsartId): bool
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['zahlungsmethode'])) {
            return strval($zahlungsartId) === $_SESSION['zahlungsmethode'];
        }

        return false;
    }

    public function unsetWarenkorb(): void
    {
        unset($_SESSION['warenkorb']);
        unset($_SESSION['lieferadresseWasEdited']);
        unset($_SESSION['newStreet']);
        unset($_SESSION['newNumber']);
        unset($_SESSION['newPostalCode']);
        unset($_SESSION['newCity']);
        unset($_SESSION['newZusatz']);
        unset($_SESSION['newVorname']);
        unset($_SESSION['newNachname']);
        unset($_SESSION['newTelefonnummer']);
        unset($_SESSION['rabattcode']);
        unset($_SESSION['rabatt']);
        unset($_SESSION['trinkgeld']);
        unset($_SESSION['andereTrinkgeld']);
        unset($_SESSION['zahlungsmethode']);
    }

    public function saveBestellung(array $bestellungMenues, array $bestellungProdukte, Kunde $kunde, ?Rabatt $rabatt, ?string $trinkgeld, string $zahlungsmethodeId): bool
    {
        $bestellung = new Bestellung();

        $bestellungMenuesCollection = new ArrayCollection();
        foreach ($bestellungMenues as $menueId => $count) {
            $bestellungMenue = new BestellungMenue();
            $bestellungMenue->setMenue($this->getMenueById($menueId));
            $bestellungMenue->setMenge($count);
            $bestellungMenue->setBestellung($bestellung);

            $bestellungMenuesCollection->add($bestellungMenue);
        }
        $bestellung->setBestellungMenues($bestellungMenuesCollection);

        $bestellungProdukteCollection = new ArrayCollection();
        foreach ($bestellungProdukte as $produktId => $count) {
            $bestellungProdukt = new BestellungProdukt();
            $bestellungProdukt->setProdukt($this->getProduktById($produktId));
            $bestellungProdukt->setMenge($count);
            $bestellungProdukt->setBestellung($bestellung);

            $bestellungProdukteCollection->add($bestellungProdukt);
        }
        $bestellung->setBestellungProdukte($bestellungProdukteCollection);

        $bestellung->setKunde($kunde);

        if (!empty($trinkgeld)) {
            $bestellung->setTrinkgeld($trinkgeld);
        }

        if (!empty($rabatt)) {
            $bestellung->setRabatt($rabatt);
        }

        $zahlungsArtRepository = new ZahlungsartRepository($this->entityManager);
        $zahlungsArt = $zahlungsArtRepository->getById(intval($zahlungsmethodeId));
        $bestellung->setZahlungsart($zahlungsArt);

        $bestellung->setBestellungDatum(new DateTime());

        $bestellungRepository = new BestellungRepository($this->entityManager);
        if (!$bestellungRepository->save($bestellung)) {
            $this->errorMessage = "Konnte Bestellung nicht erstellen!";
            return false;
        }

        $this->errorMessage = "";
        return true;
    }
}