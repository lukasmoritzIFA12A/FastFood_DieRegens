<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Kunde;
use App\datenbank\Entitaeten\Login;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;

class KundeRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Kunde::class);
    }

    public function findByUsername($username): Kunde|bool
    {
        try {
            $loginRepository = new LoginRepository($this->getEntityManager());
            $login = $loginRepository->findByUsername($username);
            if (!$login) {
                return false;
            }

            $query = $this->getEntityManager()->createQueryBuilder()
                ->select('k')
                ->from(Kunde::class, 'k')
                ->where('k.login = :loginId')
                ->setParameter('loginId', $login->getId())
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