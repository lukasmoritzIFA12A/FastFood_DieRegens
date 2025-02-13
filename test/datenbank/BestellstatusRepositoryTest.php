<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/BestellstatusRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\BestellstatusRepository;

class BestellstatusRepositoryTest extends DatenbankTest
{
    private static BestellstatusRepository $bestellstatusRepository;

    public static function setUpBeforeClass(): void
    {
        self::$bestellstatusRepository = new BestellstatusRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$bestellstatusRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $statusName = "In Bearbeitung";

        $insertedStatus = self::$bestellstatusRepository->insert($statusName);

        $this->assertNotNull($insertedStatus);
        $this->assertGreaterThan(0, $insertedStatus->getId());
        $this->assertEquals($statusName, $insertedStatus->getStatus());
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $statusName = "In Bearbeitung";
        $insertedStatus = self::$bestellstatusRepository->insert($statusName);

        $retrievedStatus = self::$bestellstatusRepository->getById($insertedStatus->getId());

        $this->assertNotNull($retrievedStatus);
        $this->assertEquals($statusName, $retrievedStatus->getStatus());
    }

    /**
     * @throws SQL
     */
    public function testGetAll(): void
    {

    }

    /**
     * @throws SQL
     */
    public function testUpdate(): void
    {
        $statusName = "In Bearbeitung";
        $insertedStatus = self::$bestellstatusRepository->insert($statusName);

        $updatedStatusName = "Versendet";
        $updatedId = self::$bestellstatusRepository->update($insertedStatus->getId(), $updatedStatusName);

        $updatedStatus = self::$bestellstatusRepository->getById($updatedId);

        $this->assertNotNull($updatedStatus);
        $this->assertEquals($updatedStatusName, $updatedStatus->getStatus());
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        self::$bestellstatusRepository->insert("In Bearbeitung");
        self::$bestellstatusRepository->insert("Versendet");

        self::$bestellstatusRepository->deleteAll();

        $statuses = self::$bestellstatusRepository->getAll();
        $this->assertEmpty($statuses);
    }

    protected function testDeleteById(): void
    {
        // TODO: Implement testDeleteById() method.
    }
}