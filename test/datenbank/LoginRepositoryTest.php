<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/LoginRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\LoginRepository;

class LoginRepositoryTest extends DatenbankTest
{
    private static LoginRepository $loginRepository;

    public static function setUpBeforeClass(): void
    {
        self::$loginRepository = new LoginRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$loginRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $nutzername = "TestUser1";
        $passwort = "Password1";

        $insertedLogin = self::$loginRepository->insert($nutzername, $passwort);

        $this->assertNotNull($insertedLogin);
        $this->assertGreaterThan(0, $insertedLogin->getId());
        $this->assertEquals($nutzername, $insertedLogin->getNutzername());
        $this->assertEquals($passwort, $insertedLogin->getPasswort());
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $nutzername = "TestUser2";
        $passwort = "Password2";

        $insertedLogin = self::$loginRepository->insert($nutzername, $passwort);

        $retrievedLogin = self::$loginRepository->getById($insertedLogin->getId());

        $this->assertNotNull($retrievedLogin);
        $this->assertEquals($nutzername, $retrievedLogin->getNutzername());
        $this->assertEquals($passwort, $retrievedLogin->getPasswort());
    }

    /**
     * @throws SQL
     */
    public function testUpdate(): void
    {
        $nutzername = "OldUser";
        $passwort = "OldPass";

        $insertedLogin = self::$loginRepository->insert($nutzername, $passwort);

        $updatedId = self::$loginRepository->update($insertedLogin->getId(), "NewUser", "NewPass");

        $updatedLogin = self::$loginRepository->getById($updatedId);

        $this->assertNotNull($updatedLogin);
        $this->assertEquals("NewUser", $updatedLogin->getNutzername());
        $this->assertEquals("NewPass", $updatedLogin->getPasswort());
    }

    /**
     * @throws SQL
     */
    public function testGetAll(): void
    {
        self::$loginRepository->insert("TestUser3", "Password3");
        self::$loginRepository->insert("TestUser4", "Password4");

        $allLogins = self::$loginRepository->getAll();

        $this->assertIsArray($allLogins);
        $this->assertCount(2, $allLogins);

        $firstLogin = array_values($allLogins)[0] ?? null;
        $this->assertNotNull($firstLogin);
        $this->assertEquals("TestUser3", $firstLogin->getNutzername());
    }

    /**
     * @throws SQL
     */
    public function testDeleteById(): void
    {
        $nutzername = "DeleteMe";
        $passwort = "DeletePass";

        $insertedLogin = self::$loginRepository->insert($nutzername, $passwort);

        self::$loginRepository->deleteById($insertedLogin->getId());

        $deletedLogin = self::$loginRepository->getById($insertedLogin->getId());
        $this->assertNull($deletedLogin);
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        self::$loginRepository->insert("ToDelete1", "Pass1");
        self::$loginRepository->insert("ToDelete2", "Pass2");

        self::$loginRepository->deleteAll();

        $allLogins = self::$loginRepository->getAll();
        $this->assertEmpty($allLogins);
    }
}