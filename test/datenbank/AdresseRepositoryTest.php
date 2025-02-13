<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/AdresseRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\AdresseRepository;

class AdresseRepositoryTest extends DatenbankTest
{
    private static AdresseRepository $adresseRepository;

    public static function setUpBeforeClass(): void
    {
        self::$adresseRepository = new AdresseRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$adresseRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $strassenname = "Baumstr.";
        $hausnummer = "21b";
        $hausnummerzusatz = null;
        $plz = "90523";
        $stadt = "Nürnberg";
        $bundesland = "Bayern";

        $insertedAdresse = self::$adresseRepository->insert($strassenname, $hausnummer, $hausnummerzusatz, $plz, $stadt, $bundesland);

        $this->assertNotNull($insertedAdresse);
        $this->assertEquals($strassenname, $insertedAdresse->getStrassenname());
        $this->assertEquals($hausnummer, $insertedAdresse->getHausnummer());
        $this->assertEquals($hausnummerzusatz, $insertedAdresse->getZusatz());
        $this->assertEquals($plz, $insertedAdresse->getPLZ());
        $this->assertEquals($stadt, $insertedAdresse->getStadt());
        $this->assertEquals($bundesland, $insertedAdresse->getBundesland());
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $strassenname = "Baumstr.";
        $hausnummer = "21b";
        $hausnummerzusatz = null;
        $plz = "90523";
        $stadt = "Nürnberg";
        $bundesland = "Bayern";

        $insertedAdresse = self::$adresseRepository->insert($strassenname, $hausnummer, $hausnummerzusatz, $plz, $stadt, $bundesland);

        $retrievedAdresse = self::$adresseRepository->getById($insertedAdresse->getId());

        $this->assertNotNull($retrievedAdresse);
        $this->assertEquals($insertedAdresse->getId(), $retrievedAdresse->getId());
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        $strassenname = "Baumstr.";
        $hausnummer = "21b";
        $hausnummerzusatz = null;
        $plz = "90523";
        $stadt = "Nürnberg";
        $bundesland = "Bayern";

        self::$adresseRepository->insert($strassenname, $hausnummer, $hausnummerzusatz, $plz, $stadt, $bundesland);
        self::$adresseRepository->insert($strassenname, $hausnummer, $hausnummerzusatz, $plz, $stadt, $bundesland);

        self::$adresseRepository->deleteAll();

        $adressen = self::$adresseRepository->getAll();
        $this->assertEmpty($adressen);
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