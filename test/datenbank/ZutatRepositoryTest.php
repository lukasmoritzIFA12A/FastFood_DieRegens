<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Repositories\ZutatRepository;
use DatenbankTest;

class ZutatRepositoryTest extends DatenbankTest
{
    private static ZutatRepository $zutatRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$zutatRepository =  new ZutatRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$zutatRepository->deleteAll();
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