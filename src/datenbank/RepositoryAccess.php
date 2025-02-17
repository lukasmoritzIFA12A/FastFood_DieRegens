<?php

namespace datenbank;

use datenbank\Entitaeten\Admin;
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

    /**
     * @throws Exception
     */
    function getById(int $id): object
    {
        $entity = $this->find($id);

        if (!$entity)
        {
            throw new Exception("Entität mit ID $id wurde nicht gefunden.");
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

    /**
     * @throws ORMException
     */
    function save(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->getEntityManager()->flush();
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

    function deleteAll(): void
    {
        $this->getEntityManager()->createQuery("DELETE FROM ".$this->getEntityName())->execute();
    }
}