<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/LoginRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/DatenbankAccess.php';

use PHPUnit\Framework\TestCase;
use RedBeanPHP\RedException\SQL;
use Repositories\LoginRepository;
use DatenbankAccess;

class LoginRepositoryTest extends TestCase
{
    private static LoginRepository $loginRepository;
    private static DatenbankAccess $datenbankAccess;

    public static function setUpBeforeClass(): void
    {
        $configs = include dirname(__DIR__, 2) . '/datenbank/Config.php';
        self::$datenbankAccess = new DatenbankAccess($configs['dbtestname']);

        self::$loginRepository = new LoginRepository();

        self::$loginRepository->deleteAll();
    }

    protected function setUp(): void
    {
        self::$loginRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        // Eintrag hinzufügen
        $nutzername = "TestUser1";
        $passwort = "Password1";

        $insertedLogin = self::$loginRepository->insert($nutzername, $passwort);

        // Prüfe, ob das Objekt zurückgegeben wird
        $this->assertNotNull($insertedLogin, "Das eingefügte Login-Objekt sollte nicht null sein.");
        $this->assertGreaterThan(0, $insertedLogin->getId(), "Die ID des eingefügten Objekts sollte größer als 0 sein.");
        $this->assertEquals($nutzername, $insertedLogin->getNutzername(), "Der Nutzername sollte dem erwarteten Wert entsprechen.");
        $this->assertEquals($passwort, $insertedLogin->getPasswort(), "Das Passwort sollte dem erwarteten Wert entsprechen.");
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        // Eintrag hinzufügen
        $nutzername = "TestUser2";
        $passwort = "Password2";

        $insertedLogin = self::$loginRepository->insert($nutzername, $passwort);

        // Per ID abrufen
        $retrievedLogin = self::$loginRepository->getById($insertedLogin->getId());

        // Sicherstellen, dass der Abruf korrekt funktioniert
        $this->assertNotNull($retrievedLogin, "Das abgerufene Login-Objekt sollte nicht null sein.");
        $this->assertEquals($nutzername, $retrievedLogin->getNutzername(), "Der Nutzername sollte dem gespeicherten Wert entsprechen.");
        $this->assertEquals($passwort, $retrievedLogin->getPasswort(), "Das Passwort sollte dem gespeicherten Wert entsprechen.");
    }

    /**
     * @throws SQL
     */
    public function testUpdate(): void
    {
        // Eintrag hinzufügen
        $nutzername = "OldUser";
        $passwort = "OldPass";

        $insertedLogin = self::$loginRepository->insert($nutzername, $passwort);

        // Eintrag aktualisieren
        $updatedId = self::$loginRepository->update($insertedLogin->getId(), "NewUser", "NewPass");

        // Geändertes Objekt abrufen
        $updatedLogin = self::$loginRepository->getById($updatedId);

        // Sicherstellen, dass die Daten aktualisiert wurden
        $this->assertNotNull($updatedLogin, "Das aktualisierte Login-Objekt darf nicht null sein.");
        $this->assertEquals("NewUser", $updatedLogin->getNutzername(), "Der Nutzername sollte aktualisiert worden sein.");
        $this->assertEquals("NewPass", $updatedLogin->getPasswort(), "Das Passwort sollte aktualisiert worden sein.");
    }

    /**
     * @throws SQL
     */
    public function testGetAll(): void
    {
        // Mehrere Einträge hinzufügen
        self::$loginRepository->insert("TestUser3", "Password3");
        self::$loginRepository->insert("TestUser4", "Password4");

        $allLogins = self::$loginRepository->getAll();

        // Sicherstellen, dass beide Einträge geladen werden
        $this->assertIsArray($allLogins, "Die Rückgabe von getAll() sollte ein Array sein.");
        $this->assertCount(2, $allLogins, "Es sollten 2 Einträge in der Datenbank gespeichert sein.");

        // Zusätzliche Überprüfung des ersten Eintrags
        $firstLogin = array_values($allLogins)[0] ?? null;
        $this->assertNotNull($firstLogin, "Der erste Eintrag sollte nicht null sein.");
        $this->assertEquals("TestUser3", $firstLogin->getNutzername(), "Der Nutzername des ersten Eintrags sollte mit dem erwarteten Wert übereinstimmen.");
    }

    /**
     * @throws SQL
     */
    public function testDeleteById(): void
    {
        // Eintrag hinzufügen
        $nutzername = "DeleteMe";
        $passwort = "DeletePass";

        $insertedLogin = self::$loginRepository->insert($nutzername, $passwort);

        // Eintrag löschen
        self::$loginRepository->deleteById($insertedLogin->getId());

        // Überprüfen, ob der Eintrag nach dem Löschen weg ist
        $deletedLogin = self::$loginRepository->getById($insertedLogin->getId());
        $this->assertNull($deletedLogin, "Der gelöschte Login-Eintrag sollte nicht existieren.");
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        // Mehrere Einträge hinzufügen
        self::$loginRepository->insert("ToDelete1", "Pass1");
        self::$loginRepository->insert("ToDelete2", "Pass2");

        // Alle Einträge löschen
        self::$loginRepository->deleteAll();

        // Überprüfen, ob alle Einträge gelöscht wurden
        $allLogins = self::$loginRepository->getAll();
        $this->assertEmpty($allLogins, "Nach dem Löschen aller Einträge sollte die Tabelle leer sein.");
    }
}