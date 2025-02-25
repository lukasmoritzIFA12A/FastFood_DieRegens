<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Icon;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class IconRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Icon::class);
    }
}