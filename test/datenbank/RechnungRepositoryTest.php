<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Rechnung;
use App\datenbank\Repositories\RechnungRepository;
use DateTime;
use Test\DatenbankTest;

class RechnungRepositoryTest extends DatenbankTest
{
    private static RechnungRepository $rechnungRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$rechnungRepository = new RechnungRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$rechnungRepository->deleteAll();
    }

    public static function createRechnung(string $loginName): Rechnung
    {
        $rechnung = new Rechnung();

        $bestellung = BestellungRepositoryTest::createBestellung($loginName);
        $rechnung->setBestellung($bestellung);
        $rechnung->setZahlungsDatum(new DateTime("2023-01-01 10:00:00"));
        return $rechnung;
    }

    public function testSaveByInsert(): void
    {
        //given
        $rechnung = self::createRechnung("UserInsert");

        //when
        self::$rechnungRepository->save($rechnung);
        $savedRechnung = self::$rechnungRepository->getById($rechnung->getId());

        //then
        $this->assertInstanceOf(Rechnung::class, $savedRechnung);
        $this->assertEquals($rechnung->getZahlungsDatum(), $savedRechnung->getZahlungsDatum());
        $this->assertEquals($rechnung->getBestellung()->getId(), $savedRechnung->getBestellung()->getId());
    }

    public function testSaveByUpdate(): void
    {
        //given
        $rechnung = self::createRechnung("UserUpdate");
        self::$rechnungRepository->save($rechnung);

        //when
        $rechnung->setZahlungsDatum(new DateTime("2023-01-02 12:00:00"));

        self::$rechnungRepository->save($rechnung);
        $updatedRechnung = self::$rechnungRepository->getById($rechnung->getId());

        //then
        $this->assertInstanceOf(Rechnung::class, $updatedRechnung);
        $this->assertEquals($rechnung->getZahlungsDatum(), $updatedRechnung->getZahlungsDatum());
    }

    public function testGetAll(): void
    {
        //given
        $rechnung = self::createRechnung("UserGetAll1");
        self::$rechnungRepository->save($rechnung);
        $rechnung = self::createRechnung("UserGetAll2");
        self::$rechnungRepository->save($rechnung);
        $rechnung = self::createRechnung("UserGetAll3");
        self::$rechnungRepository->save($rechnung);

        //when
        $allRechnungen = self::$rechnungRepository->getAll();

        //then
        $this->assertCount(3, $allRechnungen);
    }

    public function testExists(): void
    {
        //given
        $rechnung = self::createRechnung("UserExists");
        self::$rechnungRepository->save($rechnung);

        //when
        $exists = self::$rechnungRepository->exists($rechnung->getId());
        $doesNotExist = self::$rechnungRepository->exists(-1);

        //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
        //given
        $rechnung = self::createRechnung("UserDelete");
        self::$rechnungRepository->save($rechnung);
        $id = $rechnung->getId();

        //when
        $deleted = self::$rechnungRepository->deleteById($id);
        $stillExists = self::$rechnungRepository->exists($id);

        //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
        //given
        $rechnung = self::createRechnung("UserDeleteAll1");
        self::$rechnungRepository->save($rechnung);
        $rechnung = self::createRechnung("UserDeleteAll2");
        self::$rechnungRepository->save($rechnung);
        $rechnung = self::createRechnung("UserDeleteAll3");
        self::$rechnungRepository->save($rechnung);

        //when
        self::$rechnungRepository->deleteAll();

        //then
        $this->assertEmpty(self::$rechnungRepository->getAll());
    }
}