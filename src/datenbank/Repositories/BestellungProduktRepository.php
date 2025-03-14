<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\BestellungProdukt;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class BestellungProduktRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, BestellungProdukt::class);
    }
}