<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Zahlungsart.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Zahlungsart;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class ZahlungsartRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Zahlungsart::class);
    }
}