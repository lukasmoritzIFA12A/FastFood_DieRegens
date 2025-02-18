<?php

namespace datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/LoginRepositoryTest.php';

use datenbank\Entitaeten\Admin;
use datenbank\Repositories\AdminRepository;
use DatenbankTest;

class AdminRepositoryTest extends DatenbankTest
{
    private static AdminRepository $adminRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$adminRepository = new AdminRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$adminRepository->deleteAll();
    }

    public static function createAdmin(string $nutzername): Admin
    {
        $admin = new Admin();

        $login = LoginRepositoryTest::createLogin($nutzername);
        $admin->setLogin($login);
        return $admin;
    }

    public function testSaveByInsert(): void
    {
    //when
        $admin = $this->createAdmin("NutzerInsert");
        self::$adminRepository->save($admin);
        $savedAdmin = self::$adminRepository->getById($admin->getLogin()->getId());

    //then
        $this->assertInstanceOf(Admin::class, $savedAdmin);
        $this->assertNotNull($savedAdmin->getLogin());
        $this->assertEquals($admin->getLogin()->getNutzername(), $savedAdmin->getLogin()->getNutzername());
        $this->assertEquals($admin->getLogin()->getPasswort(), $savedAdmin->getLogin()->getPasswort());
    }

    public function testSaveByUpdate(): void
    {
        //Braucht der AdminRepository nicht
        $this->assertTrue(true);
    }

    public function testGetAll(): void
    {
    //given
        for ($i = 1; $i <= 3; $i++)
        {
            $admin = $this->createAdmin("NutzerGet$i");
            self::$adminRepository->save($admin);
        }

    //when
        $admins = self::$adminRepository->getAll();

    //then
        $this->assertCount(3, $admins);
    }

    public function testExists(): void
    {
    //given
        $admin = $this->createAdmin("Nutzer0");
        self::$adminRepository->save($admin);

    //when
        $ifExistsTrue = self::$adminRepository->exists($admin->getLogin()->getId());
        $ifExistsFalse = self::$adminRepository->exists(-1);

    //then
        $this->assertTrue($ifExistsTrue);
        $this->assertFalse($ifExistsFalse);
    }

    public function testDeleteById(): void
    {
        //Braucht der AdminRepository nicht
        $this->assertTrue(true);
    }

    public function testDeleteAll(): void
    {
    //given
        for ($i = 1; $i <= 3; $i++)
        {
            $admin = $this->createAdmin("NutzerDelete$i");
            self::$adminRepository->save($admin);
        }

    //when
        self::$adminRepository->deleteAll();

    //then
        $this->assertEmpty(self::$adminRepository->getAll());
    }
}