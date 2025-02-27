<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Bild;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class BildRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Bild::class);
    }
}