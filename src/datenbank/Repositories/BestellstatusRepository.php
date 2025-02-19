<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Bestellstatus;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class BestellstatusRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Bestellstatus::class);
    }
}