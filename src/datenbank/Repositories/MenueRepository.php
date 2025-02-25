<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Menue;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class MenueRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Menue::class);
    }
}