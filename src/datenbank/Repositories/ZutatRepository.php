<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Zutat.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Zutat;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class ZutatRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Zutat::class);
    }
}