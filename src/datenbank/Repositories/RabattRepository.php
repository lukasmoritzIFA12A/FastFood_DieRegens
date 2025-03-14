<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Rabatt;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;

class RabattRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Rabatt::class);
    }

    public function getRabattByCode($rabattCode): Rabatt|bool
    {
        try {
            $query = $this->getEntityManager()->createQueryBuilder()
                ->select('r')
                ->from(Rabatt::class, 'r')
                ->where('r.code = :code')
                ->setParameter('code', $rabattCode)
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