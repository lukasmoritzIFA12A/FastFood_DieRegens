<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Login.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Login;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class LoginRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Login::class);
    }
}