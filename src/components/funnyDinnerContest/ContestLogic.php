<?php

namespace App\components\funnyDinnerContest;

use App\datenbank\Entitaeten\Bild;
use App\datenbank\Entitaeten\Contest;
use App\datenbank\Entitaeten\Kunde;
use App\datenbank\Entitaeten\Rating;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\BestellungRepository;
use App\datenbank\Repositories\ContestRepository;
use App\datenbank\Repositories\KundeRepository;
use App\datenbank\Repositories\RatingRepository;
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

    public function saveRating(string $contestId, string $rating, string $kundeId): bool
    {
        $contestRepository = new ContestRepository($this->entityManager);
        $contestObj = $contestRepository->getById($contestId);
        if (!$contestObj) {
            $this->errorMessage = "Konnte Contest nicht finden!";
            return false;
        }

        $kundeRepository = new KundeRepository($this->entityManager);
        $kundeObj = $kundeRepository->getById($kundeId);
        if (!$kundeObj) {
            $this->errorMessage = "Kunde konnte nicht gefunden werden!";
            return false;
        }

        $ratingObj = new Rating();
        $ratingObj->setContest($contestObj);
        $ratingObj->setKunde($kundeObj);
        $ratingObj->setRating(intval($rating));

        $ratingRepository = new RatingRepository($this->entityManager);
        return $ratingRepository->save($ratingObj);
    }

    public function getKundeByUserName(string $user): Kunde|bool
    {
        $kundeRepository = new KundeRepository($this->entityManager);
        $kunde = $kundeRepository->findByUsername($user);
        if (!$kunde) {
            return false;
        }
        return $kunde;
    }

    public function hasUserRatedAlreadyOnContest(Kunde $kunde, Contest $contest): bool
    {
        $ratingRepository = new RatingRepository($this->entityManager);
        $ratings = $ratingRepository->getKundenRatingsFromContest($kunde, $contest);
        return !empty($ratings);
    }

    public function getUserRatingFromContest(Kunde $kunde, Contest $contest): Rating
    {
        $ratingRepository = new RatingRepository($this->entityManager);
        $ratings = $ratingRepository->getKundenRatingsFromContest($kunde, $contest);
        return $ratings[0];
    }
}