<?php

namespace datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Entitaeten\Login;
use datenbank\Repositories\LoginRepository;
use DatenbankTest;

class LoginRepositoryTest extends DatenbankTest
{
    private static LoginRepository $loginRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$loginRepository =  new LoginRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$loginRepository->deleteAll();
    }

    public static function createLogin(string $nutzername): Login
    {
        $login = new Login();
        $login->setNutzername($nutzername);
        $login->setPasswort("Geheim");
        return $login;
    }

    public function testSaveByInsert(): void
    {
    //given
        $login = self::createLogin("UserInsert");

    //when
        self::$loginRepository->save($login);
        $savedLogin = self::$loginRepository->getById($login->getId());

    //then
        $this->assertInstanceOf(Login::class, $savedLogin);
        $this->assertEquals($login->getNutzername(), $savedLogin->getNutzername());
        $this->assertEquals($login->getPasswort(), $savedLogin->getPasswort());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $login = self::createLogin("UserUpdate");
        self::$loginRepository->save($login);

    //when
        $login->setNutzername("UserNewName");
        self::$loginRepository->save($login);

        $updatedLogin = self::$loginRepository->getById($login->getId());

    //then
        $this->assertInstanceOf(Login::class, $updatedLogin);
        $this->assertEquals($login->getNutzername(), $updatedLogin->getNutzername());
    }

    public function testGetAll(): void
    {
    //given
        $login = self::createLogin("UserGet1");
        self::$loginRepository->save($login);
        $login = self::createLogin("UserGet2");
        self::$loginRepository->save($login);
        $login = self::createLogin("UserGet3");
        self::$loginRepository->save($login);

    //when
        $allLogins = self::$loginRepository->getAll();

    //then
        $this->assertCount(3, $allLogins);
    }

    public function testExists(): void
    {
    //given
        $login = self::createLogin("UserExists");
        self::$loginRepository->save($login);

    //when
        $exists = self::$loginRepository->exists($login->getId());
        $doesNotExist = self::$loginRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $login = self::createLogin("UserDelete");
        self::$loginRepository->save($login);
        $id = $login->getId();

    //when
        $deleted = self::$loginRepository->deleteById($id);
        $stillExists = self::$loginRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $login = self::createLogin("UserGet1");
        self::$loginRepository->save($login);
        $login = self::createLogin("UserGet2");
        self::$loginRepository->save($login);
        $login = self::createLogin("UserGet3");
        self::$loginRepository->save($login);

    //when
        self::$loginRepository->deleteAll();

    //then
        $this->assertEmpty(self::$loginRepository->getAll());
    }
}