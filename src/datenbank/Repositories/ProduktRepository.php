<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Produkt;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class ProduktRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Produkt::class);
    }
}