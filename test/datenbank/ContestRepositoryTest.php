<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/ContestRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/BestellungRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/KundeRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/ZahlungsartRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/BestellstatusRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/AdresseRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/LoginRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\AdresseRepository;
use src\datenbank\Repositories\BestellstatusRepository;
use src\datenbank\Repositories\BestellungRepository;
use src\datenbank\Repositories\ContestRepository;
use src\datenbank\Repositories\KundeRepository;
use src\datenbank\Repositories\LoginRepository;
use src\datenbank\Repositories\ZahlungsartRepository;

class ContestRepositoryTest extends DatenbankTest
{
    private static ContestRepository $contestRepository;
    private static BestellungRepository $bestellungRepository;
    private static AdresseRepository $adresseRepository;
    private static KundeRepository $kundeRepository;
    private static ZahlungsartRepository $zahlungsartRepository;
    private static BestellstatusRepository $bestellstatusRepository;
    private static LoginRepository $loginRepository;

    public static function setUpBeforeClass(): void
    {
        self::$contestRepository = new ContestRepository();
        self::$bestellungRepository = new BestellungRepository();
        self::$adresseRepository = new AdresseRepository();
        self::$kundeRepository = new KundeRepository();
        self::$zahlungsartRepository = new ZahlungsartRepository();
        self::$bestellstatusRepository = new BestellstatusRepository();
        self::$loginRepository = new LoginRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$contestRepository->deleteAll();
        self::$bestellungRepository->deleteAll();
        self::$adresseRepository->deleteAll();
        self::$kundeRepository->deleteAll();
        self::$zahlungsartRepository->deleteAll();
        self::$bestellstatusRepository->deleteAll();
        self::$loginRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $login = self::$loginRepository->insert("User", "Passwort");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");
        $kunde = self::$kundeRepository->insert($adresse->getId(), "Max", "Mustermann", "123456789", "2023-10-01 00:00:00", $login->getId());
        $zahlungsart = self::$zahlungsartRepository->insert("Kreditkarte");
        $bestellstatus = self::$bestellstatusRepository->insert("Bestellung in Bearbeitung");
        $bestellung = self::$bestellungRepository->insert("2023-10-15 00:00:00", $kunde->getId(), $zahlungsart->getId(), $bestellstatus->getId());

        $bild = base64_encode("Testbild ");
        $bestellungId = $bestellung->getId();
        $freigeschalten = false;

        $insertedContest = self::$contestRepository->insert(
            $bild,
            $bestellungId,
            $freigeschalten
        );

        $this->assertNotNull($insertedContest);
        $this->assertNotNull($insertedContest->getBild());
        $this->assertEquals($bestellungId, $insertedContest->getBestellungId());
        $this->assertEquals($freigeschalten, $insertedContest->isFreigeschalten());
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        $login = self::$loginRepository->insert("User", "Passwort");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");
        $kunde = self::$kundeRepository->insert($adresse->getId(), "Max", "Mustermann", "123456789", "2023-10-01 00:00:00", $login->getId());
        $zahlungsart = self::$zahlungsartRepository->insert("Kreditkarte");
        $bestellstatus = self::$bestellstatusRepository->insert("Bestellung in Bearbeitung");
        $bestellung = self::$bestellungRepository->insert("2023-10-15 00:00:00", $kunde->getId(), $zahlungsart->getId(), $bestellstatus->getId());

        $bild = base64_encode("Testbild ");
        $bestellungId = $bestellung->getId();
        $freigeschalten = false;

        self::$contestRepository->insert($bild, $bestellungId, $freigeschalten);
        self::$contestRepository->insert($bild, $bestellungId, $freigeschalten);

        self::$contestRepository->deleteAll();

        $contests = self::$contestRepository->getAll();
        $this->assertEmpty($contests);
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $login = self::$loginRepository->insert("User", "Passwort");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");
        $kunde = self::$kundeRepository->insert($adresse->getId(), "Max", "Mustermann", "123456789", "2023-10-01 00:00:00", $login->getId());
        $zahlungsart = self::$zahlungsartRepository->insert("Kreditkarte");
        $bestellstatus = self::$bestellstatusRepository->insert("Bestellung in Bearbeitung");
        $bestellung = self::$bestellungRepository->insert("2023-10-15 00:00:00", $kunde->getId(), $zahlungsart->getId(), $bestellstatus->getId());

        $bild = base64_encode("Testbild ");
        $bestellungId = $bestellung->getId();
        $freigeschalten = false;

        $insertedContest = self::$contestRepository->insert(
            $bild,
            $bestellungId,
            $freigeschalten
        );

        $retrievedContest = self::$contestRepository->getById($insertedContest->getId());

        $this->assertNotNull($retrievedContest);
        $this->assertEquals($insertedContest->getId(), $retrievedContest->getId());
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