<?php

namespace App\datenbank\Repositories;

use App\datenbank\Entitaeten\Bestellung;
use App\datenbank\Entitaeten\Kunde;
use App\datenbank\RepositoryAccess;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NonUniqueResultException;

class BestellungRepository extends RepositoryAccess
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Bestellung::class);
    }

    public function getBestellungenByKunde(Kunde $kunde): array|bool
    {
        $query = $this->getEntityManager()->createQueryBuilder()
            ->select('b')
            ->from(Bestellung::class, 'b')
            ->where('b.kunde = :kundeId')
            ->setParameter('kundeId', $kunde->getId())
            ->getQuery();

        $result = $query->getResult();
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
}