<?php

namespace datenbank\Repositories;

include_once dirname(__DIR__) . '/Entitaeten/Icon.php';
include_once dirname(__DIR__) . '/RepositoryAccess.php';

use datenbank\Entitaeten\Icon;
use datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;

class IconRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Icon::class);
    }
}