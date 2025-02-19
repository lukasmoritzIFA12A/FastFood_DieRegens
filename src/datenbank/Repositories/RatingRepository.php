<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Rating;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class RatingRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Rating::class);
    }
}