<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Rating.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Rating;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class RatingRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Rating::class);
    }
}