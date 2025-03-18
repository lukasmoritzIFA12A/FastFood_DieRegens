<?php

namespace App\components\admin;

use App\datenbank\Entitaeten\Bestellstatus;
use App\datenbank\Entitaeten\Bild;
use App\datenbank\Entitaeten\Energiewert;
use App\datenbank\Entitaeten\Menue;
use App\datenbank\Entitaeten\Produkt;
use App\datenbank\Entitaeten\Rabatt;
use App\datenbank\Entitaeten\Zahlungsart;
use App\datenbank\Entitaeten\Zutat;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\BestellstatusRepository;
use App\datenbank\Repositories\EnergiewertRepository;
use App\datenbank\Repositories\MenueRepository;
use App\datenbank\Repositories\ProduktRepository;
use App\datenbank\Repositories\RabattRepository;
use App\datenbank\Repositories\ZahlungsartRepository;
use App\datenbank\Repositories\ZutatRepository;
use DeepCopy\f001\B;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class AdminLogic
{
    private EntityManager $entityManager;
    public string $errorMessage = "";

    public function __construct()
    {
        $entityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $entityManagerFactory->createEntityManager();
    }

    public function saveBestellstatus(string $orderStatus, string $orderStatusColor): bool
    {
        $bestellstatus = new Bestellstatus();
        $bestellstatus->setStatus($orderStatus);
        $bestellstatus->setFarbe($orderStatusColor);

        $bestellstatusRepository = new BestellstatusRepository($this->entityManager);
        return $bestellstatusRepository->save($bestellstatus);
    }

    public function saveProdukt($titel, $beschreibung, $preis, $tempPath, $istAusverkauft, $rawzutaten, $energiewert): bool
    {
        $this->unsetEnergiewerteSession();

        $produkt = new Produkt();
        $produkt->setTitel($titel);
        $produkt->setBeschreibung($beschreibung);
        $produkt->setPreis($preis);

        $fileData = file_get_contents($tempPath);
        $bild = new Bild();
        $bild->setBild($fileData);

        $produkt->setBild($bild);
        $produkt->setAusverkauft($istAusverkauft);

        $zutaten = new ArrayCollection();
        $zutatRepository = new ZutatRepository($this->entityManager);
        foreach ($rawzutaten as $rawzutat) {
            $zutat = $zutatRepository->getById($rawzutat);
            if ($zutat) {
                $zutaten->add($zutat);
            }
        }

        $produkt->setZutat($zutaten);
        $produkt->setEnergiewert($energiewert);

        $produktRepository = new ProduktRepository($this->entityManager);
        return $produktRepository->save($produkt);
    }

    public function saveMenue($titel, $beschreibung, $tempPath, $rawProdukte): bool
    {
        $menue = new Menue();
        $menue->setTitel($titel);
        $menue->setBeschreibung($beschreibung);

        $fileData = file_get_contents($tempPath);
        $bild = new Bild();
        $bild->setBild($fileData);

        $menue->setBild($bild);

        $produkte = new ArrayCollection();
        $produktRepository = new ProduktRepository($this->entityManager);
        foreach ($rawProdukte as $rawProdukt) {
            $produkt = $produktRepository->getById($rawProdukt);
            if ($produkt) {
                $produkte->add($produkt);
            }
        }
        $menue->setProdukte($produkte);

        $menueRepository = new MenueRepository($this->entityManager);
        return $menueRepository->save($menue);
    }

    public function getAllZutaten(): array
    {
        $zutatenRepository = new ZutatRepository($this->entityManager);
        $zutaten = $zutatenRepository->getAll();
        if (!$zutaten) {
            return [];
        }
        return $zutaten;
    }

    public function getAllProdukte(): array
    {
        $produktRepository = new ProduktRepository($this->entityManager);
        $produkte = $produktRepository->getAll();
        if (!$produkte) {
            return [];
        }
        return $produkte;
    }

    public function saveZutat(string $zutat): bool
    {
        $zutatObj = new Zutat();
        $zutatObj->setZutatName($zutat);

        $zutatRepository = new ZutatRepository($this->entityManager);
        return $zutatRepository->save($zutatObj);
    }

    public function saveZahlungsart(string $art, string $tempPath): bool
    {
        $zahlungsart = new Zahlungsart();
        $zahlungsart->setArt($art);

        $fileData = file_get_contents($tempPath);
        $bild = new Bild();
        $bild->setBild($fileData);

        $zahlungsart->setBild($bild);

        $zahlungsartRepository = new ZahlungsartRepository($this->entityManager);
        if (!$zahlungsartRepository->save($zahlungsart)) {
            $this->errorMessage = "Zahlungsart konnte nicht gespeichert werden!";
            return false;
        }

        return true;
    }

    public function getAllMenues(): array
    {
        $menueRepository = new MenueRepository($this->entityManager);
        $menues = $menueRepository->getAll();
        if (!$menues) {
            return [];
        }
        return $menues;
    }

    public function getAllBestellstatus(): array
    {
        $bestellstatusRepository = new BestellstatusRepository($this->entityManager);
        $bestellstatus = $bestellstatusRepository->getAll();
        if (!$bestellstatus) {
            return [];
        }
        return $bestellstatus;
    }

    public function getEnergiewerte(): array
    {
        $energiewerteRepository = new EnergiewertRepository($this->entityManager);
        $energiewerte = $energiewerteRepository->getAll();
        if (!$energiewerte) {
            return [];
        }
        return $energiewerte;
    }

    public function getAllZahlungsarten(): array
    {
        $zahlungsartRepository = new ZahlungsartRepository($this->entityManager);
        $zahlungsart = $zahlungsartRepository->getAll();
        if (!$zahlungsart) {
            return [];
        }
        return $zahlungsart;
    }

    public function unsetEnergiewerteSession(): void
    {
        unset($_SESSION['energiewertProdukte']);
        unset($_SESSION['portionSize']);
        unset($_SESSION['kalorien']);
        unset($_SESSION['fett']);
        unset($_SESSION['kohlenhydrate']);
        unset($_SESSION['zucker']);
        unset($_SESSION['eiweiss']);
    }

    public function saveRabatt(string $rabattcode, string $rabatt): bool
    {
        $rabattObj = new Rabatt();
        $rabattObj->setCode($rabattcode);
        $rabattObj->setMinderung($rabatt);

        $rabattRepository = new RabattRepository($this->entityManager);
        if (!$rabattRepository->save($rabattObj)) {
            $this->errorMessage = "Rabatt konnte nicht gespeichert werden!";
            return false;
        }

        return true;
    }

    public function getAllRabatte(): array
    {
        $rabattRepository = new RabattRepository($this->entityManager);
        $rabatte = $rabattRepository->getAll();
        if (!$rabatte) {
            return [];
        }
        return $rabatte;
    }

    public function deleteBestellstatus(string $id): bool
    {
        $bestellstatusRepository = new BestellstatusRepository($this->entityManager);
        return $bestellstatusRepository->deleteById($id);
    }

    public function deleteMenue(string $id): bool
    {
        $menueRepository = new MenueRepository($this->entityManager);
        return $menueRepository->deleteById($id);
    }

    public function deleteProdukt(string $id): bool
    {
        $produktRepository = new ProduktRepository($this->entityManager);
        return $produktRepository->deleteById($id);
    }

    public function deleteRabatt(string $id): bool
    {
        $rabattRepository = new RabattRepository($this->entityManager);
        return $rabattRepository->deleteById($id);
    }

    public function deleteZahlungsart(string $id): bool
    {
        $zahlungsartRepository = new ZahlungsartRepository($this->entityManager);
        return $zahlungsartRepository->deleteById($id);
    }

    public function deleteZutat(string $id): bool
    {
        $zutatRepository = new ZutatRepository($this->entityManager);
        return $zutatRepository->deleteById($id);
    }

    public function updateBestellstatus($id, $orderStatus, $orderStatusColor): bool
    {
        $bestellstatusRepository = new BestellstatusRepository($this->entityManager);
        $bestellstatusObj = $bestellstatusRepository->getById($id);
        if (!$bestellstatusObj) {
            $this->errorMessage = "Konnte Bestellstatus nicht finden!";
            return false;
        }

        $bestellstatusObj->setStatus($orderStatus);
        $bestellstatusObj->setFarbe($orderStatusColor);

        return $bestellstatusRepository->save($bestellstatusObj);
    }

    public function updateMenue($id, $titel, $beschreibung, $tempPath, $produkteCollection): bool
    {
        $menueRepository = new MenueRepository($this->entityManager);
        $menueObj = $menueRepository->getById($id);
        if (!$menueObj) {
            $this->errorMessage = "Konnte Menü nicht finden!";
            return false;
        }

        $menueObj->setTitel($titel);
        $menueObj->setBeschreibung($beschreibung);

        $fileData = file_get_contents($tempPath);
        $bild = new Bild();
        $bild->setBild($fileData);

        $menueObj->setBild($bild);

        $produkte = new ArrayCollection();
        $produktRepository = new ProduktRepository($this->entityManager);
        foreach ($produkteCollection as $rawProdukt) {
            $produkt = $produktRepository->getById($rawProdukt);
            if ($produkt) {
                $produkte->add($produkt);
            }
        }
        $menueObj->setProdukte($produkte);

        return $menueRepository->save($menueObj);
    }

    public function updateProdukt($id, $titel, $beschreibung, $preis, $tempPath, $istAusverkauft, $zutatenCollection, $energiewert): bool
    {
        $produktRepository = new ProduktRepository($this->entityManager);
        $produktObj = $produktRepository->getById($id);
        if (!$produktObj) {
            $this->errorMessage = "Konnte Produkt nicht finden!";
            return false;
        }

        $produktObj->setTitel($titel);
        $produktObj->setBeschreibung($beschreibung);
        $produktObj->setPreis($preis);

        $fileData = file_get_contents($tempPath);
        $bild = new Bild();
        $bild->setBild($fileData);

        $produktObj->setBild($bild);
        $produktObj->setAusverkauft($istAusverkauft);

        $zutaten = new ArrayCollection();
        $zutatRepository = new ZutatRepository($this->entityManager);
        foreach ($zutatenCollection as $rawzutat) {
            $zutat = $zutatRepository->getById($rawzutat);
            if ($zutat) {
                $zutaten->add($zutat);
            }
        }

        $produktObj->setZutat($zutaten);
        $produktObj->setEnergiewert($energiewert);

        return $produktRepository->save($produktObj);
    }

    public function updateRabatt($id, $rabattcode, $rabatt): bool
    {
        $rabattRepository = new RabattRepository($this->entityManager);
        $rabattObj = $rabattRepository->getById($id);
        if (!$rabattObj) {
            $this->errorMessage = "Konnte Rabatt nicht finden!";
            return false;
        }

        $rabattObj->setCode($rabattcode);
        $rabattObj->setMinderung($rabatt);

        return $rabattRepository->save($rabattObj);
    }

    public function updateZahlungsart($id, $art, $tempPath): bool
    {
        $zahlungsartRepository = new ZahlungsartRepository($this->entityManager);
        $zahlungsartObj = $zahlungsartRepository->getById($id);
        if (!$zahlungsartObj) {
            $this->errorMessage = "Konnte Zahlungsart nicht finden!";
            return false;
        }

        $zahlungsartObj->setArt($art);

        $fileData = file_get_contents($tempPath);
        $bild = new Bild();
        $bild->setBild($fileData);

        $zahlungsartObj->setBild($bild);

        return $zahlungsartRepository->save($zahlungsartObj);
    }

    public function updateZutat($id, $zutat): bool
    {
        $zutatRepository = new ZutatRepository($this->entityManager);
        $zutatObj = $zutatRepository->getById($id);
        if (!$zutatObj) {
            $this->errorMessage = "Konnte Zutat nicht finden!";
            return false;
        }

        $zutatObj->setZutatName($zutat);

        return $zutatRepository->save($zutatObj);
    }
}