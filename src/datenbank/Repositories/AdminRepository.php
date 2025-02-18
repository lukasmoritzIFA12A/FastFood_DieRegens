<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Admin;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class AdminRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Admin::class);
    }
}