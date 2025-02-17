<?php

use datenbank\EntityManagerFactory;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

abstract class DatenbankTest extends TestCase
{
    protected static function cleanup(): void
    {
        error_log("Default Implementation von cleanup");
    }

    public static function createEntityManager(): EntityManager
    {
        $entityManager = EntityManagerFactory::createEntityManager(true);
        EntityManagerFactory::dropSchema($entityManager);
        EntityManagerFactory::updateSchema($entityManager);
        return $entityManager;
    }

    protected function setUp(): void
    {
        static::cleanup();
    }

    abstract public function testSaveByInsert(): void;
    abstract public function testSaveByUpdate(): void;
    abstract public function testGetAll(): void;
    abstract public function testExists(): void;
    abstract public function testDeleteById(): void;
    abstract public function testDeleteAll(): void;
}