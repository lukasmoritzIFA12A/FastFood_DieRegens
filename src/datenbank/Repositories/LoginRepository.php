<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Login;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;

class LoginRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Login::class);
    }

    public function findByUsername($username): Login|bool
    {
        try {
            $query = $this->getEntityManager()->createQueryBuilder()
                ->select('u')
                ->from(Login::class, 'u')
                ->where('u.Nutzername = :name')
                ->setParameter('name', $username)
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