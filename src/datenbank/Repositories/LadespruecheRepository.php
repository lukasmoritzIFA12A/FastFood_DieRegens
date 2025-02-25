<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Ladesprueche;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class LadespruecheRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Ladesprueche::class);
    }
}