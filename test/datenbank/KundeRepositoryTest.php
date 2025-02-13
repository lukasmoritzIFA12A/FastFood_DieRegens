<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/AdresseRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/KundeRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/LoginRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\AdresseRepository;
use src\datenbank\Repositories\KundeRepository;
use src\datenbank\Repositories\LoginRepository;

class KundeRepositoryTest extends DatenbankTest
{
    private static LoginRepository $loginRepository;
    private static AdresseRepository $adresseRepository;
    private static KundeRepository $kundeRepository;

    public static function setUpBeforeClass(): void
    {
        self::$loginRepository = new LoginRepository();
        self::$adresseRepository = new AdresseRepository();
        self::$kundeRepository = new KundeRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$loginRepository->deleteAll();
        self::$adresseRepository->deleteAll();
        self::$kundeRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $login = self::$loginRepository->insert("User", "Passwort");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");

        $adresseId = $adresse->getId();
        $vorname = "Vorname";
        $nachname = "Nachname";
        $telefonnummer = "Telefonnummer";
        $registrierungsdatum = "2023-10-01 00:00:00";
        $loginId = $login->getId();

        $insertedKunde = self::$kundeRepository->insert(
            $adresseId,
            $vorname,
            $nachname,
            $telefonnummer,
            $registrierungsdatum,
            $loginId
        );

        $this->assertNotNull($insertedKunde);
        $this->assertEquals($adresseId, $insertedKunde->getAdresseId());
        $this->assertEquals($vorname, $insertedKunde->getVorname());
        $this->assertEquals($nachname, $insertedKunde->getNachname());
        $this->assertEquals($telefonnummer, $insertedKunde->getTelefonnummer());
        $this->assertEquals($registrierungsdatum, $insertedKunde->getRegistrierungsdatum());
        $this->assertEquals($loginId, $insertedKunde->getLoginId());
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        $login = self::$loginRepository->insert("User", "Passwort");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");

        $adresseId = $adresse->getId();
        $vorname = "Vorname";
        $nachname = "Nachname";
        $telefonnummer = "Telefonnummer";
        $registrierungsdatum = "2023-10-01 00:00:00";
        $loginId = $login->getId();

        self::$kundeRepository->insert($adresseId, $vorname, $nachname, $telefonnummer, $registrierungsdatum, $loginId);
        self::$kundeRepository->insert($adresseId, $vorname, $nachname, $telefonnummer, $registrierungsdatum, $loginId);

        self::$kundeRepository->deleteAll();

        $kunden = self::$kundeRepository->getAll();
        $this->assertEmpty($kunden);
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $login = self::$loginRepository->insert("User", "Passwort");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");

        $adresseId = $adresse->getId();
        $vorname = "Vorname";
        $nachname = "Nachname";
        $telefonnummer = "Telefonnummer";
        $registrierungsdatum = "2023-10-01 00:00:00";
        $loginId = $login->getId();

        $insertedKunde = self::$kundeRepository->insert($adresseId, $vorname, $nachname, $telefonnummer, $registrierungsdatum, $loginId);

        $retrievedKunde = self::$kundeRepository->getById($insertedKunde->getId());

        $this->assertNotNull($retrievedKunde);
        $this->assertEquals($insertedKunde->getId(), $retrievedKunde->getId());
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