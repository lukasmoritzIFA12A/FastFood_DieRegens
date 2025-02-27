<?php

namespace App\datenbank;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use mysqli_sql_exception;

/**
 * @template T
 */
class RepositoryAccess extends EntityRepository
{
    private EntityManager $entityManager;

    function __construct(EntityManager $entityManager, string $entitaetsKlasse)
    {
        $this->entityManager = $entityManager;
        try {
            parent::__construct($entityManager, $entityManager->getClassMetadata($entitaetsKlasse));
        } catch (Exception $e) {
            error_log("Mysql Verbindung fehlgeschlagen: ".$e->getMessage());

            header('Content-Type: text/html; charset=utf-8');
            $htmlContent = file_get_contents('../../components/error/error-datenbank.html');
            echo $htmlContent;

            die;
        }
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