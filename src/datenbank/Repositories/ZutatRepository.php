<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Login;
use App\datenbank\Entitaeten\Zutat;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;

class ZutatRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Zutat::class);
    }

    public function findByZutatName($zutatName): Zutat|bool
    {
        try {
            $query = $this->getEntityManager()->createQueryBuilder()
                ->select('z')
                ->from(Zutat::class, 'z')
                ->where('z.ZutatName = :name')
                ->setParameter('name', $zutatName)
                ->getQuery();

            $result = $query->getOneOrNullResult();
            if ($result) {
                return $result;
            } else {
                return false;
            }
        } catch (NonUniqueResultException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}