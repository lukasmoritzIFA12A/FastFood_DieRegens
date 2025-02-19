<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Rechnung;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class RechnungRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Rechnung::class);
    }
}