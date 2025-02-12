<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/BestellstatusRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/DatenbankAccess.php';

use PHPUnit\Framework\TestCase;
use Repositories\BestellstatusRepository;
use DatenbankAccess;
use RedBeanPHP\RedException\SQL;

class BestellstatusRepositoryTest extends TestCase
{
    private static BestellstatusRepository $bestellstatusRepository;
    private static DatenbankAccess $datenbankAccess;

    public static function setUpBeforeClass(): void
    {
        $configs = include dirname(__DIR__, 2) . '/datenbank/Config.php';
        self::$datenbankAccess = new DatenbankAccess($configs['dbtestname']);
        self::$bestellstatusRepository = new BestellstatusRepository();

        self::$bestellstatusRepository->deleteAll();
    }

    protected function setUp(): void
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
}