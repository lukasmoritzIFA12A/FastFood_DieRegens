<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Zahlungsart;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class ZahlungsartRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Zahlungsart::class);
    }
}