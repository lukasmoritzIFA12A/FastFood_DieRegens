<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/EnergiewertRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/ProduktRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/IconRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\EnergiewertRepository;
use src\datenbank\Repositories\IconRepository;
use src\datenbank\Repositories\ProduktRepository;

class EnergiewertRepositoryTest extends DatenbankTest
{
    private static IconRepository $iconRepository;
    private static ProduktRepository $produktRepository;
    private static EnergiewertRepository $energiewertRepository;

    public static function setUpBeforeClass(): void
    {
        self::$iconRepository = new IconRepository();
        self::$produktRepository = new ProduktRepository();
        self::$energiewertRepository = new EnergiewertRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$iconRepository->deleteAll();
        self::$produktRepository->deleteAll();
        self::$energiewertRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $icon = self::$iconRepository->insert("Pfad/Zum/Huhn");
        $produkt = self::$produktRepository->insert($icon->getId(), "Titel", "Beschreibung", 10.99, 10, null);

        $produktId = $produkt->getId();
        $portionSize = "Size";
        $kalorien = 10.21;
        $fett = 10.22;
        $kohlenhydrate = 10.23;
        $zucker = 10.24;
        $eiweiss = 10.25;

        $insertedEnergiewert = self::$energiewertRepository->insert(
            $produktId,
            $portionSize,
            $kalorien,
            $fett,
            $kohlenhydrate,
            $zucker,
            $eiweiss
        );

        $this->assertNotNull($insertedEnergiewert);
        $this->assertEquals($produktId, $insertedEnergiewert->getProduktId());
        $this->assertEquals($portionSize, $insertedEnergiewert->getPortionSize());
        $this->assertEquals($kalorien, $insertedEnergiewert->getKalorien());
        $this->assertEquals($fett, $insertedEnergiewert->getFett());
        $this->assertEquals($kohlenhydrate, $insertedEnergiewert->getKohlenhydrate());
        $this->assertEquals($zucker, $insertedEnergiewert->getZucker());
        $this->assertEquals($eiweiss, $insertedEnergiewert->getEiweiss());
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        $icon = self::$iconRepository->insert("Pfad/Zum/Huhn");
        $produkt = self::$produktRepository->insert($icon->getId(), "Titel", "Beschreibung", 10.99, 10, null);

        $produktId = $produkt->getId();
        $portionSize = "Size";
        $kalorien = 10.21;
        $fett = 10.22;
        $kohlenhydrate = 10.23;
        $zucker = 10.24;
        $eiweiss = 10.25;

        self::$energiewertRepository->insert($produktId, $portionSize, $kalorien, $fett, $kohlenhydrate, $zucker, $eiweiss);
        self::$energiewertRepository->insert($produktId, $portionSize, $kalorien, $fett, $kohlenhydrate, $zucker, $eiweiss);

        self::$energiewertRepository->deleteAll();

        $energiewerte = self::$energiewertRepository->getAll();
        $this->assertEmpty($energiewerte);
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $icon = self::$iconRepository->insert("Pfad/Zum/Huhn");
        $produkt = self::$produktRepository->insert($icon->getId(), "Titel", "Beschreibung", 10.99, 10, null);

        $produktId = $produkt->getId();
        $portionSize = "Size";
        $kalorien = 10.21;
        $fett = 10.22;
        $kohlenhydrate = 10.23;
        $zucker = 10.24;
        $eiweiss = 10.25;

        $insertedEnergiewert = self::$energiewertRepository->insert($produktId, $portionSize, $kalorien, $fett, $kohlenhydrate, $zucker, $eiweiss);

        $retrievedEnergiewert = self::$energiewertRepository->getById($insertedEnergiewert->getId());

        $this->assertNotNull($retrievedEnergiewert);
        $this->assertEquals($insertedEnergiewert->getId(), $retrievedEnergiewert->getId());
    }

    protected function testGetAll(): void
    {
        // TODO: Implement testGetAll() method.
    }

    protected function testUpdate(): void
    {
        // TODO: Implement testUpdate() method.
    }

    protected function testDeleteById(): void
    {
        // TODO: Implement testDeleteById() method.
    }
}