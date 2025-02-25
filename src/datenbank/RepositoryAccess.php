<?php

namespace App\datenbank;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

/**
 * @template T
 */
class RepositoryAccess extends EntityRepository
{
    private EntityManager $entityManager;

    function __construct(EntityManager $entityManager, string $entitaetsKlasse)
    {
        parent::__construct($entityManager, $entityManager->getClassMetadata($entitaetsKlasse));
        $this->entityManager = $entityManager;
    }

    function getById(int $id): ?object
    {
        $entity = $this->find($id);

        if (!$entity)
        {
            return null;
        }

        return $entity;
    }

    function exists(int $id): bool
    {
        try
        {
            return $this->getById($id) !== null;
        }
        catch (Exception)
        {
            return false;
        }
    }

    function save(object $entity): bool
    {
        try
        {
            $this->entityManager->persist($entity);
            $this->getEntityManager()->flush();
            return true;
        }
        catch (ORMException $e)
        {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * @return array<T>|null
     */
    function getAll(): ?array
    {
        return $this->findAll();
    }

    function deleteById(int $id): bool
    {
        try
        {
            $entity = $this->find($id);
            if ($entity !== null) {
                $this->entityManager->remove($entity);
                $this->entityManager->flush();
                return true;
            }
            return false;
        }
        catch (OptimisticLockException | ORMException $e)
        {
            error_log($e->getMessage());
            return false;
        }
    }

    /** @noinspection SqlWithoutWhere */
    function deleteAll(): void
    {
        $this->getEntityManager()->createQuery("DELETE FROM ".$this->getEntityName())->execute();
    }

    function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }
}