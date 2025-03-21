<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Kunde;
use App\datenbank\Entitaeten\Rating;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;

class RatingRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Rating::class);
    }

    public function getKundenRatingsFromContest($kunde, $contest): array|bool
    {
        try {
            $query = $this->getEntityManager()->createQueryBuilder()
                ->select('r')
                ->from(Rating::class, 'r')
                ->where('r.kunde = :kundeId')
                ->andWhere('r.contest = :contestId')
                ->setParameter('kundeId', $kunde->getId())
                ->setParameter('contestId', $contest->getId())
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