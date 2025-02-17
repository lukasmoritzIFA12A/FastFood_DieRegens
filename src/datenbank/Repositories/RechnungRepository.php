<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Rechnung.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Rechnung;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class RechnungRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Rechnung::class);
    }
}