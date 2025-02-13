<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/AdminRepository.php';
include_once dirname(__DIR__, 2) . '/datenbank/Repositories/LoginRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\AdminRepository;
use src\datenbank\Repositories\LoginRepository;

class AdminRepositoryTest extends DatenbankTest
{
    private static AdminRepository $adminRepository;
    private static LoginRepository $loginRepository;

    public static function setUpBeforeClass(): void
    {
        self::$adminRepository = new AdminRepository();
        self::$loginRepository = new LoginRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$adminRepository->deleteAll();
        self::$loginRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $login = self::$loginRepository->insert("AdminUser", "SecurePassword");

        $insertedAdmin = self::$adminRepository->insert($login->getId());

        $this->assertNotNull($insertedAdmin);
        $this->assertEquals($login->getId(), $insertedAdmin->getLoginId());
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $login = self::$loginRepository->insert("TestGetById", "PasswordGetById");

        self::$adminRepository->insert($login->getId());

        $retrievedAdmin = self::$adminRepository->getById($login->getId());

        $this->assertNotNull($retrievedAdmin);
        $this->assertEquals($login->getId(), $retrievedAdmin->getLoginId());
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        $login1 = self::$loginRepository->insert("AdminUser1", "Password1");
        $login2 = self::$loginRepository->insert("AdminUser2", "Password2");

        self::$adminRepository->insert($login1->getId());
        self::$adminRepository->insert($login2->getId());

        self::$adminRepository->deleteAll();

        $admins = self::$adminRepository->getAll();
        $this->assertEmpty($admins);
    }

    /**
     * @throws SQL
     */
    public function testGetAll(): void
    {
        $login1 = self::$loginRepository->insert("Test1", "Password1");
        $login2 = self::$loginRepository->insert("Test2", "Password2");

        self::$adminRepository->insert($login1->getId());
        self::$adminRepository->insert($login2->getId());

        $allAdmins = self::$adminRepository->getAll();

        $this->assertIsArray($allAdmins);
        $this->assertCount(2, $allAdmins);

        $firstAdmin = array_values($allAdmins)[0] ?? null;
        $this->assertNotNull($firstAdmin);
        $this->assertEquals($login1->getId(), $firstAdmin->getLoginId());
    }

    public function testUpdate(): void
    {
        //Gibt es bei Admin Repository nicht!
        $this->assertTrue(true);
    }

    public function testDeleteById(): void
    {
        //Gibt es bei Admin Repository nicht!
        $this->assertTrue(true);
    }
}