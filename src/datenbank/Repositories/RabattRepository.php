<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Rabatt;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class RabattRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Rabatt::class);
    }
}