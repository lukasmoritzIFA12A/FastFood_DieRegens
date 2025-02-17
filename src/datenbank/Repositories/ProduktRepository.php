<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Produkt.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Produkt;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class ProduktRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Produkt::class);
    }
}