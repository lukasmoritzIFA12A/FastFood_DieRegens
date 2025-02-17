<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Contest.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Contest;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class ContestRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Contest::class);
    }
}