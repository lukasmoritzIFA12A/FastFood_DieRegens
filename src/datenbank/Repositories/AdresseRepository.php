<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Adresse.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Adresse;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class AdresseRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Adresse::class);
    }
}