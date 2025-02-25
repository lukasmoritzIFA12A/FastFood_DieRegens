<?php

namespace App\components\startseite;

use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\MenueRepository;
use App\datenbank\Repositories\ProduktRepository;
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
}