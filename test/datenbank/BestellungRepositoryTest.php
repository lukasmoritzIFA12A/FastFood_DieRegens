<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/BestellungRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/KundeRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/ZahlungsartRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/ProduktRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/MenueRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/BestellstatusRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/AdresseRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/LoginRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/IconRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/DatenbankAccess.php';

use PHPUnit\Framework\TestCase;
use Repositories\AdresseRepository;
use Repositories\BestellungRepository;
use Repositories\IconRepository;
use Repositories\KundeRepository;
use Repositories\LoginRepository;
use Repositories\ZahlungsartRepository;
use Repositories\ProduktRepository;
use Repositories\MenueRepository;
use Repositories\BestellstatusRepository;
use DatenbankAccess;
use RedBeanPHP\RedException\SQL;

class BestellungRepositoryTest extends TestCase
{
    private static BestellungRepository $bestellungRepository;
    private static AdresseRepository $adresseRepository;
    private static KundeRepository $kundeRepository;
    private static ZahlungsartRepository $zahlungsartRepository;
    private static ProduktRepository $produktRepository;
    private static MenueRepository $menueRepository;
    private static BestellstatusRepository $bestellstatusRepository;
    private static LoginRepository $loginRepository;
    private static IconRepository $iconRepository;
    private static DatenbankAccess $datenbankAccess;

    public static function setUpBeforeClass(): void
    {
        $configs = include dirname(__DIR__, 2) . '/datenbank/Config.php';
        self::$datenbankAccess = new DatenbankAccess($configs['dbtestname']);
        self::$bestellungRepository = new BestellungRepository();
        self::$adresseRepository = new AdresseRepository();
        self::$kundeRepository = new KundeRepository();
        self::$zahlungsartRepository = new ZahlungsartRepository();
        self::$produktRepository = new ProduktRepository();
        self::$menueRepository = new MenueRepository();
        self::$bestellstatusRepository = new BestellstatusRepository();
        self::$loginRepository = new LoginRepository();
        self::$iconRepository = new IconRepository();

        self::$bestellungRepository->deleteAll();
        self::$adresseRepository->deleteAll();
        self::$kundeRepository->deleteAll();
        self::$zahlungsartRepository->deleteAll();
        self::$produktRepository->deleteAll();
        self::$menueRepository->deleteAll();
        self::$bestellstatusRepository->deleteAll();
        self::$loginRepository->deleteAll();
        self::$iconRepository->deleteAll();
    }

    protected function setUp(): void
    {
        self::$bestellungRepository->deleteAll();
        self::$adresseRepository->deleteAll();
        self::$kundeRepository->deleteAll();
        self::$zahlungsartRepository->deleteAll();
        self::$produktRepository->deleteAll();
        self::$menueRepository->deleteAll();
        self::$bestellstatusRepository->deleteAll();
        self::$loginRepository->deleteAll();
        self::$iconRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $login = self::$loginRepository->insert("User", "Passwort");
        $icon = self::$iconRepository->insert("icon.png");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");
        $kunde = self::$kundeRepository->insert($adresse->getId(), "Max", "Mustermann", "123456789", "2023-10-01 00:00:00", $login->getId());
        $zahlungsart = self::$zahlungsartRepository->insert("Kreditkarte");
        $produkt = self::$produktRepository->insert($icon->getId(), "Produkt Titel", "Beschreibung", 19.99, 50, 0);
        $menue = self::$menueRepository->insert("Mittagsmenü", "Beschreibung für das Menü");
        $bestellstatus = self::$bestellstatusRepository->insert("Bestellung in Bearbeitung");

        $bestellungdatum = "2023-10-15 00:00:00";

        $insertedBestellung = self::$bestellungRepository->insert(
            $bestellungdatum,
            $kunde->getId(),
            $zahlungsart->getId(),
            $produkt->getId(),
            $menue->getId(),
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
        $icon = self::$iconRepository->insert("icon.png");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");
        $kunde = self::$kundeRepository->insert($adresse->getId(), "Max", "Mustermann", "123456789", "2023-10-01 00:00:00", $login->getId());
        $zahlungsart = self::$zahlungsartRepository->insert("Kreditkarte");
        $produkt = self::$produktRepository->insert($icon->getId(), "Produkt Titel", "Beschreibung", 19.99, 50, 0);
        $menue = self::$menueRepository->insert("Mittagsmenü", "Beschreibung für das Menü");
        $bestellstatus = self::$bestellstatusRepository->insert("Bestellung in Bearbeitung");

        $bestellungdatum = "2023-10-15 00:00:00";
        $insertedBestellung = self::$bestellungRepository->insert(
            $bestellungdatum,
            $kunde->getId(),
            $zahlungsart->getId(),
            $produkt->getId(),
            $menue->getId(),
            $bestellstatus->getId()
        );

        $updatedBestellungdatum = "2023-10-16 00:00:00";
        $updatedStatus = self::$bestellstatusRepository->insert("Bestellung fertig");

        $updatedId = self::$bestellungRepository->update(
            $insertedBestellung->getId(),
            $updatedBestellungdatum,
            $kunde->getId(),
            $zahlungsart->getId(),
            $produkt->getId(),
            $menue->getId(),
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
        $icon = self::$iconRepository->insert("icon.png");
        $adresse = self::$adresseRepository->insert("Baumstr.", "21b", null, "90523", "Nürnberg", "Bayern");
        $kunde = self::$kundeRepository->insert($adresse->getId(), "Max", "Mustermann", "123456789", "2023-10-01 00:00:00", $login->getId());
        $zahlungsart = self::$zahlungsartRepository->insert("Kreditkarte");
        $produkt = self::$produktRepository->insert($icon->getId(), "Produkt Titel", "Beschreibung", 19.99, 50, 0);
        $menue = self::$menueRepository->insert("Mittagsmenü", "Beschreibung für das Menü");
        $bestellstatus = self::$bestellstatusRepository->insert("Bestellung in bearbeitet");

        self::$bestellungRepository->insert("2023-10-15 00:00:00", $kunde->getId(), $zahlungsart->getId(), $produkt->getId(), $menue->getId(), $bestellstatus->getId());
        self::$bestellungRepository->insert("2023-10-16 00:00:00", $kunde->getId(), $zahlungsart->getId(), $produkt->getId(), $menue->getId(), $bestellstatus->getId());

        self::$bestellungRepository->deleteAll();

        $bestellungen = self::$bestellungRepository->getAll();
        $this->assertEmpty($bestellungen);
    }
}