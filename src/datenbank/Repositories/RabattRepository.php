<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Rabatt.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Rabatt;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class RabattRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Rabatt::class);
    }
}