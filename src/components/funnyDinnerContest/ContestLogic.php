<?php

namespace App\components\funnyDinnerContest;

use App\datenbank\Entitaeten\Bild;
use App\datenbank\Entitaeten\Contest;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\BestellungRepository;
use App\datenbank\Repositories\ContestRepository;
use App\datenbank\Repositories\KundeRepository;
use Doctrine\ORM\EntityManager;

class ContestLogic
{
    private EntityManager $entityManager;
    public string $errorMessage = "";

    public function __construct()
    {
        $entityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $entityManagerFactory->createEntityManager();
    }

    public function getAllBestellungenFromKunde($username): array|bool
    {
        $kundeRepository = new KundeRepository($this->entityManager);
        $kunde = $kundeRepository->findByUsername($username);
        if (!$kunde) {
            $this->errorMessage = "Kunde konnte nicht gefunden werden!";
            return false;
        }

        $bestellungRepository = new BestellungRepository($this->entityManager);
        $bestellungen = $bestellungRepository->getBestellungenByKunde($kunde);
        if (!$bestellungen) {
            return [];
        }
        return $bestellungen;
    }

    public function getBestellungHint($bestellung): string
    {
        $inhalte = [];

        foreach ($bestellung->getBestellungprodukte() as $produkt) {
            $inhalte[] = $produkt->getProdukt()->getTitel();
            if (count($inhalte) >= 3) {
                break;
            }
        }
        foreach ($bestellung->getBestellungmenues() as $menue) {
            $inhalte[] = $menue->getMenue()->getTitel();
            if (count($inhalte) >= 3) {
                break;
            }
        }

        return empty($inhalte) ? 'Keine Inhalte 😥' : implode(', ', $inhalte) . (count($inhalte) === 3 ? ' ...' : '');
    }

    public function saveContest($bestellId, $tempPath): bool
    {
        $bestellungRepository = new BestellungRepository($this->entityManager);
        $bestellung = $bestellungRepository->getById($bestellId);
        if (!$bestellung) {
            $this->errorMessage = "Konnte Bestellung nicht finden!";
            return false;
        }

        $contest = new Contest();
        $contest->setBestellung($bestellung);
        $contest->setFreigeschalten(false);

        $fileData = file_get_contents($tempPath);
        $bild = new Bild();
        $bild->setBild($fileData);
        $contest->setBild($bild);

        $contestRepository = new ContestRepository($this->entityManager);
        return $contestRepository->save($contest);
    }

    public function getAllContests(): array
    {
        $contestRepository = new ContestRepository($this->entityManager);
        $contests = $contestRepository->getAll();
        if (!$contests) {
            return [];
        }
        return $contests;
    }
}