<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Kunde.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Kunde;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class KundeRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Kunde::class);
    }
}