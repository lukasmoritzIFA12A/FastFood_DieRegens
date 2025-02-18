<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Kunde;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class KundeRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Kunde::class);
    }
}