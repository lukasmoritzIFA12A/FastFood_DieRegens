<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Repositories\RechnungRepository;
use DatenbankTest;

class RechnungRepositoryTest extends DatenbankTest
{
    private static RechnungRepository $rechnungRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$rechnungRepository =  new RechnungRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$rechnungRepository->deleteAll();
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