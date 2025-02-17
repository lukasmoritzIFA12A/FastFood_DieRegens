<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Menue.php';

use datenbank\Entitaeten\Menue;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class MenueRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Menue::class);
    }
}