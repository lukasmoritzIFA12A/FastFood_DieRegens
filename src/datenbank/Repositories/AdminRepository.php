<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Admin.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Admin;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class AdminRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Admin::class);
    }
}