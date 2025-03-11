<?php

namespace App\components\startseite;

use App\datenbank\Entitaeten\Energiewert;
use App\datenbank\Entitaeten\Menue;
use App\datenbank\Entitaeten\Produkt;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\EnergiewertRepository;
use App\datenbank\Repositories\MenueRepository;
use App\datenbank\Repositories\ProduktRepository;
use App\utils\ImageLoader;
use Doctrine\ORM\EntityManager;

class StartseiteLogic
{
    private EntityManager $entityManager;

    public function __construct()
    {
        $entityManagerFactory = new EntityManagerFactory();
        $this->entityManager = $entityManagerFactory->createEntityManager();
    }

    public function getProduktList(): array
    {
        $productRepository = new ProduktRepository($this->entityManager);
        return $productRepository->getAll();
    }

    public function getMenueList(): array
    {
        $menueRepository = new MenueRepository($this->entityManager);
        return $menueRepository->getAll();
    }

    public function getTopMenue(): Menue|bool
    {
        $menueRepository = new MenueRepository($this->entityManager);
        return $menueRepository->getTopMenue();
    }
}