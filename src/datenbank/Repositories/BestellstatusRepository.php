<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Bestellstatus.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Bestellstatus;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class BestellstatusRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Bestellstatus::class);
    }
}