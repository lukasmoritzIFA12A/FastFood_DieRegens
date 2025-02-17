<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Ladesprueche.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Ladesprueche;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class LadespruecheRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Ladesprueche::class);
    }
}