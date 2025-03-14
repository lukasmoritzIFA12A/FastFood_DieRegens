<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\BestellungMenue;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class BestellungMenueRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, BestellungMenue::class);
    }
}