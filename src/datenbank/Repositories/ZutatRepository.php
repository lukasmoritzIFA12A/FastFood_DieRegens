<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Zutat;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class ZutatRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Zutat::class);
    }
}