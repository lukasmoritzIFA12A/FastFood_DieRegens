<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Entitaeten\Admin;
use datenbank\Entitaeten\Login;
use datenbank\Repositories\AdminRepository;
use DatenbankTest;
use Doctrine\ORM\Exception\ORMException;
use Exception;

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

    /**
     * @throws ORMException
     */
    public function createAndSaveAdmin(string $nutzername): Admin
    {
        $admin = new Admin();

        $login = new Login();
        $login->setNutzername($nutzername);
        $login->setPasswort("Geheim");

        $admin->setLogin($login);

        self::$adminRepository->save($admin);
        return $admin;
    }

    /**
     * @throws ORMException
     * @throws Exception
     */
    public function testSaveByInsert(): void
    {
    //when
        $admin = $this->createAndSaveAdmin("Nutzer1");
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

    /**
     * @throws ORMException
     */
    public function testGetAll(): void
    {
    //given
        for ($i = 1; $i <= 3; $i++)
        {
            $this->createAndSaveAdmin("Nutzer$i");
        }

    //when
        $admins = self::$adminRepository->getAll();

    //then
        $this->assertCount(3, $admins);
    }

    /**
     * @throws ORMException
     */
    public function testExists(): void
    {
    //given
        $admin = $this->createAndSaveAdmin("Nutzer1");

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

    /**
     * @throws ORMException
     */
    public function testDeleteAll(): void
    {
    //given
        for ($i = 1; $i <= 3; $i++)
        {
            $this->createAndSaveAdmin("Nutzer$i");
        }

    //when
        self::$adminRepository->deleteAll();

    //then
        $this->assertEmpty(self::$adminRepository->getAll());
    }
}