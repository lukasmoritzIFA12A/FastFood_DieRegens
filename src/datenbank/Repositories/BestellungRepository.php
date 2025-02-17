<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Bestellung.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Bestellung;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class BestellungRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Bestellung::class);
    }
}