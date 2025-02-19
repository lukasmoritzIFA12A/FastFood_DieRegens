<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Login;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class LoginRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Login::class);
    }
}