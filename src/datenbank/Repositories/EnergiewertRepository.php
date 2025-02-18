<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Energiewert;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class EnergiewertRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Energiewert::class);
    }
}