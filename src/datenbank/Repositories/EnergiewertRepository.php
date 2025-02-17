<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Energiewert.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Energiewert;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class EnergiewertRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Energiewert::class);
    }
}