<?php

namespace App\components\admin;

use App\datenbank\Entitaeten\Bestellstatus;
use App\datenbank\Entitaeten\Bild;
use App\datenbank\Entitaeten\Menue;
use App\datenbank\Entitaeten\Produkt;
use App\datenbank\Entitaeten\Zutat;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\BestellstatusRepository;
use App\datenbank\Repositories\MenueRepository;
use App\datenbank\Repositories\ProduktRepository;
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

    public function saveProdukt($titel, $beschreibung, $preis, $tempPath, $lagerbestand, $rawzutaten): bool
    {
        $produkt = new Produkt();
        $produkt->setTitel($titel);
        $produkt->setBeschreibung($beschreibung);
        $produkt->setPreis($preis);

        $fileData = file_get_contents($tempPath);
        $bild = new Bild();
        $bild->setBild($fileData);

        $produkt->setBild($bild);
        $produkt->setLagerbestand($lagerbestand);

        $zutaten = new ArrayCollection();
        $zutatRepository = new ZutatRepository($this->entityManager);
        foreach ($rawzutaten as $rawzutat) {
            $zutat = $zutatRepository->findByZutatName($rawzutat);
            if (!$zutat) {
                $neueZutat = new Zutat();
                $neueZutat->setZutatName($rawzutat);
                $zutaten->add($neueZutat);
            } else {
                $zutaten->add($zutat);
            }
        }
        $produkt->setZutat($zutaten);

        $produktRepository = new ProduktRepository($this->entityManager);
        return $produktRepository->save($produkt);
    }

    public function saveMenue($titel, $beschreibung, $bild, $produkte): bool
    {
        $menue = new Menue();
        $menue->setTitel($titel);
        $menue->setBeschreibung($beschreibung);
        $menue->setBild($bild);
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
}