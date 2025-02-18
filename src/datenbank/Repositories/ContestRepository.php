<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Contest;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class ContestRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Contest::class);
    }
}