<?php

namespace App\components\admin;

use App\datenbank\Entitaeten\Bestellstatus;
use App\datenbank\Entitaeten\Bild;
use App\datenbank\Entitaeten\Energiewert;
use App\datenbank\Entitaeten\Menue;
use App\datenbank\Entitaeten\Produkt;
use App\datenbank\Entitaeten\Zahlungsart;
use App\datenbank\Entitaeten\Zutat;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\BestellstatusRepository;
use App\datenbank\Repositories\EnergiewertRepository;
use App\datenbank\Repositories\MenueRepository;
use App\datenbank\Repositories\ProduktRepository;
use App\datenbank\Repositories\ZahlungsartRepository;
use App\datenbank\Repositories\ZutatRepository;
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

    public function saveProdukt($titel, $beschreibung, $preis, $tempPath, $istAusverkauft, $rawzutaten): bool
    {
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

    public function saveEnergieWerte(string $produktId, string $portionSize, string $kalorien, string $fett, string $kohlenhydrate, string $zucker, string $eiweiss): bool
    {
        $energiewert = new Energiewert();
        $energiewert->setPortionSize($portionSize);
        $energiewert->setKalorien($kalorien);
        $energiewert->setFett($fett);
        $energiewert->setKohlenhydrate($kohlenhydrate);
        $energiewert->setZucker($zucker);
        $energiewert->setEiweiss($eiweiss);

        $energiewertRepository = new EnergiewertRepository($this->entityManager);
        if (!$energiewertRepository->save($energiewert)) {
            $this->errorMessage = "Energiewerte konnten nicht gespeichert werden!";
            return false;
        }

        $produktRepository = new ProduktRepository($this->entityManager);
        $produkt = $produktRepository->getById($produktId);
        if (!$produkt) {
            $this->errorMessage = "Produkt konnte nicht gefunden werden!";
            return false;
        }

        $produkt->setEnergiewert($energiewert);
        return $produktRepository->save($produkt);
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
}