<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Kunde;
use App\datenbank\Repositories\KundeRepository;
use Test\DatenbankTest;
use DateTime;

class KundeRepositoryTest extends DatenbankTest
{
    private static KundeRepository $kundeRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$kundeRepository =  new KundeRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$kundeRepository->deleteAll();
    }

    public static function createKunde(string $LoginName): Kunde
    {
        $adresse = AdresseRepositoryTest::createAdresse();
        $login = LoginRepositoryTest::createLogin($LoginName);

        $kunde = new Kunde();
        $kunde->setVorname("Max");
        $kunde->setNachname("Mustermann");
        $kunde->setRegistrierungsdatum(new DateTime("2023-01-01 10:00:00"));
        $kunde->setAdresse($adresse);
        $kunde->setLogin($login);
        return $kunde;
    }

    public function testSaveByInsert(): void
    {
    //given
        $kunde = self::createKunde("LoginInsert");

    //when
        self::$kundeRepository->save($kunde);
        $savedKunde = self::$kundeRepository->getById($kunde->getId());

    //then
        $this->assertInstanceOf(Kunde::class, $savedKunde);
        $this->assertEquals($kunde->getVorname(), $savedKunde->getVorname());
        $this->assertEquals($kunde->getNachname(), $savedKunde->getNachname());
        $this->assertEquals($kunde->getRegistrierungsdatum(), $savedKunde->getRegistrierungsdatum());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $kunde = self::createKunde("LoginUpdate");
        self::$kundeRepository->save($kunde);

    //when
        $kunde->setVorname("Moritz");
        $kunde->setNachname("Musteränderung");
        self::$kundeRepository->save($kunde);
        $updatedKunde = self::$kundeRepository->getById($kunde->getId());

    //then
        $this->assertInstanceOf(Kunde::class, $updatedKunde);
        $this->assertEquals($kunde->getVorname(), $updatedKunde->getVorname());
        $this->assertEquals($kunde->getNachname(), $updatedKunde->getNachname());
    }

    public function testGetAll(): void
    {
    //given
        $kunde = self::createKunde("LoginGet1");
        self::$kundeRepository->save($kunde);
        $kunde = self::createKunde("LoginGet2");
        self::$kundeRepository->save($kunde);
        $kunde = self::createKunde("LoginGet3");
        self::$kundeRepository->save($kunde);

    //when
        $allKunden = self::$kundeRepository->getAll();

    //then
        $this->assertCount(3, $allKunden);
    }

    public function testExists(): void
    {
    //given
        $kunde = self::createKunde("LoginExists");
        self::$kundeRepository->save($kunde);

    //when
        $exists = self::$kundeRepository->exists($kunde->getId());
        $doesNotExist = self::$kundeRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $kunde = self::createKunde("LoginDelete");
        self::$kundeRepository->save($kunde);
        $id = $kunde->getId();

    //when
        $deleted = self::$kundeRepository->deleteById($id);
        $stillExists = self::$kundeRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $kunde = self::createKunde("LoginDelete1");
        self::$kundeRepository->save($kunde);
        $kunde = self::createKunde("LoginDelete2");
        self::$kundeRepository->save($kunde);
        $kunde = self::createKunde("LoginDelete3");
        self::$kundeRepository->save($kunde);

    //when
        self::$kundeRepository->deleteAll();

    //then
        $this->assertEmpty(self::$kundeRepository->getAll());
    }
}