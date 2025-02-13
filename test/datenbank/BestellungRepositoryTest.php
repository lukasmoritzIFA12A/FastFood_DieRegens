<?php

namespace Test\Datenbank;

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
use src\datenbank\Repositories\KundeRepository;
use src\datenbank\Repositories\LoginRepository;
use src\datenbank\Repositories\ZahlungsartRepository;

class BestellungRepositoryTest extends DatenbankTest
{
    private static BestellungRepository $bestellungRepository;
    private static AdresseRepository $adresseRepository;
    private static KundeRepository $kundeRepository;
    private static ZahlungsartRepository $zahlungsartRepository;
    private static BestellstatusRepository $bestellstatusRepository;
    private static LoginRepository $loginRepository;

    public static function setUpBeforeClass(): void
    {
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

        $bestellungdatum = "2023-10-15 00:00:00";

        $insertedBestellung = self::$bestellungRepository->insert(
            $bestellungdatum,
            $kunde->getId(),
            $zahlungsart->getId(),
            $bestellstatus->getId()
        );

        $this->assertNotNull($insertedBestellung);
        $this->assertGreaterThan(0, $insertedBestellung->getId());
        $this->assertEquals($bestellungdatum, $insertedBestellung->getBestellungDatum());
    }

    /**
     * @throws SQL
     */
    public function testUpdate(): void
    {
        $login = self::$loginRepository->insert("User", "Passwort");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");
        $kunde = self::$kundeRepository->insert($adresse->getId(), "Max", "Mustermann", "123456789", "2023-10-01 00:00:00", $login->getId());
        $zahlungsart = self::$zahlungsartRepository->insert("Kreditkarte");
        $bestellstatus = self::$bestellstatusRepository->insert("Bestellung in Bearbeitung");

        $bestellungdatum = "2023-10-15 00:00:00";
        $insertedBestellung = self::$bestellungRepository->insert(
            $bestellungdatum,
            $kunde->getId(),
            $zahlungsart->getId(),
            $bestellstatus->getId()
        );

        $updatedBestellungdatum = "2023-10-16 00:00:00";
        $updatedStatus = self::$bestellstatusRepository->insert("Bestellung fertig");

        $updatedId = self::$bestellungRepository->update(
            $insertedBestellung->getId(),
            $updatedBestellungdatum,
            $kunde->getId(),
            $zahlungsart->getId(),
            $updatedStatus->getId()
        );

        $updatedBestellung = self::$bestellungRepository->getById($updatedId);

        $this->assertNotNull($updatedBestellung);
        $this->assertEquals($updatedBestellungdatum, $updatedBestellung->getBestellungDatum());
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
        $bestellstatus = self::$bestellstatusRepository->insert("Bestellung in bearbeitet");

        self::$bestellungRepository->insert("2023-10-15 00:00:00", $kunde->getId(), $zahlungsart->getId(), $bestellstatus->getId());
        self::$bestellungRepository->insert("2023-10-16 00:00:00", $kunde->getId(), $zahlungsart->getId(), $bestellstatus->getId());

        self::$bestellungRepository->deleteAll();

        $bestellungen = self::$bestellungRepository->getAll();
        $this->assertEmpty($bestellungen);
    }

    protected function testGetById(): void
    {
        // TODO: Implement testGetById() method.
    }

    protected function testGetAll(): void
    {
        // TODO: Implement testGetAll() method.
    }

    protected function testDeleteById(): void
    {
        // TODO: Implement testDeleteById() method.
    }
}