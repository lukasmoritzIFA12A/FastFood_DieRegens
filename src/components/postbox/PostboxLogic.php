<?php

namespace App\components\postbox;

use App\datenbank\Entitaeten\Kunde;
use App\datenbank\Entitaeten\Postbox;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\KundeRepository;
use App\datenbank\Repositories\PostboxRepository;
use DateTime;
use Doctrine\ORM\EntityManager;

class PostboxLogic
{
    private EntityManager $entityManager;
    public string $errorMessage = "";

    public function __construct()
    {
        $entityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $entityManagerFactory->createEntityManager();
    }

    public function getNachrichtenFromKunde($loginName): array|bool
    {
        $kundeRepository = new KundeRepository($this->entityManager);
        $kunde = $kundeRepository->findByUsername($loginName);
        if (!$kunde) {
            $this->errorMessage = "Kunde nicht gefunden";
            return false;
        }

        $postboxRepository = new PostboxRepository($this->entityManager);
        $nachrichten = $postboxRepository->findAllByKunde($kunde);
        if (!$nachrichten) {
            return [];
        }
        return $nachrichten;
    }

    public function getUngeleseneNachrichtenFromKunde($loginName): array|bool
    {
        $nachrichten = $this->getNachrichtenFromKunde($loginName);
        if (!$nachrichten) {
            return false;
        }

        return array_filter($nachrichten, function($nachricht) {
            return $nachricht->isGelesen() === false;
        });
    }

    public function deleteNachricht(string $postboxId): bool
    {
        $postboxRepository = new PostboxRepository($this->entityManager);
        return $postboxRepository->deleteById($postboxId);
    }

    public function readNachricht(string $postboxId): bool
    {
        $postboxRepository = new PostboxRepository($this->entityManager);
        $postbox = $postboxRepository->getById($postboxId);
        if (!$postbox) {
            $this->errorMessage = "Post nicht gefunden";
            return false;
        }

        $postbox->setGelesen(true);
        return $postboxRepository->save($postbox);
    }

    public function sendPostboxNachricht(string $kundeId, string $nachricht): bool
    {
        $kundeRepository = new KundeRepository($this->entityManager);
        $kunde = $kundeRepository->getById($kundeId);
        if (!$kunde) {
            $this->errorMessage = "Kunde nicht gefunden";
            return false;
        }

        $postbox = new Postbox();
        $postbox->setNachricht($nachricht);
        $postbox->setKunde($kunde);
        $postbox->setGelesen(false);
        $postbox->setNachrichtDatum(new DateTime());

        $postboxRepository = new PostboxRepository($this->entityManager);
        return $postboxRepository->save($postbox);
    }
}