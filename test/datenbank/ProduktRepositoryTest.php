<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Repositories\ProduktRepository;
use DatenbankTest;

class ProduktRepositoryTest extends DatenbankTest
{
    private static ProduktRepository $produktRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$produktRepository =  new ProduktRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$produktRepository->deleteAll();
    }

    public function testSaveByInsert(): void
    {
        // TODO: Implement testSaveByInsert() method.
    }

    public function testSaveByUpdate(): void
    {
        // TODO: Implement testSaveByUpdate() method.
    }

    public function testGetAll(): void
    {
        // TODO: Implement testGetAll() method.
    }

    public function testExists(): void
    {
        // TODO: Implement testExists() method.
    }

    public function testDeleteById(): void
    {
        // TODO: Implement testDeleteById() method.
    }

    public function testDeleteAll(): void
    {
        // TODO: Implement testDeleteAll() method.
    }
}