<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Bestellung;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class BestellungRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Bestellung::class);
    }
}