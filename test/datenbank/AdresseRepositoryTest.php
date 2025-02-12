<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/AdresseRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/DatenbankAccess.php';

use PHPUnit\Framework\TestCase;
use Repositories\AdresseRepository;
use DatenbankAccess;
use RedBeanPHP\RedException\SQL;

class AdresseRepositoryTest extends TestCase
{
    private static AdresseRepository $adresseRepository;
    private static DatenbankAccess $datenbankAccess;

    public static function setUpBeforeClass(): void
    {
        $configs = include dirname(__DIR__, 2) . '/datenbank/Config.php';
        self::$datenbankAccess = new DatenbankAccess($configs['dbtestname']);
        self::$adresseRepository = new AdresseRepository();

        self::$adresseRepository->deleteAll();
    }

    protected function setUp(): void
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
}