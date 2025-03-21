<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Login;
use App\datenbank\Entitaeten\Postbox;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;

class PostboxRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Postbox::class);
    }

    public function findAllByKunde($kunde): array|bool
    {
        try {
            $query = $this->getEntityManager()->createQueryBuilder()
                ->select('p')
                ->from(Postbox::class, 'p')
                ->where('p.kunde = :kundeId')
                ->setParameter('kundeId', $kunde->getId())
                ->getQuery();

            $result = $query->getResult();
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