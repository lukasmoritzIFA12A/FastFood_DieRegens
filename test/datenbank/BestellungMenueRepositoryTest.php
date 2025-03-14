<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\BestellungMenue;
use App\datenbank\Repositories\BestellungMenueRepository;
use Test\DatenbankTest;

class BestellungMenueRepositoryTest extends DatenbankTest
{
    private static BestellungMenueRepository $bestellungMenueRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$bestellungMenueRepository = new BestellungMenueRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$bestellungMenueRepository->deleteAll();
    }

    public static function createBestellungMenue($loginName): BestellungMenue
    {
        $bestellungMenue = new BestellungMenue();
        $bestellungMenue->setMenge(1);
        $bestellungMenue->setMenue(MenueRepositoryTest::createMenue());
        $bestellungMenue->setBestellung(BestellungRepositoryTest::createBestellung($loginName));
        return $bestellungMenue;
    }

    public function testSaveByInsert(): void
    {
        //when
        $bestellungMenue = $this->createBestellungMenue("TestUser1");
        self::$bestellungMenueRepository->save($bestellungMenue);
        $savedBestellungMenue = self::$bestellungMenueRepository->getById($bestellungMenue->getId());

        //then
        $this->assertInstanceOf(BestellungMenue::class, $savedBestellungMenue);
        $this->assertEquals($bestellungMenue->getMenge(), $savedBestellungMenue->getMenge());
    }

    public function testSaveByUpdate(): void
    {
        //given
        $bestellungMenue = $this->createBestellungMenue("TestUser2");
        self::$bestellungMenueRepository->save($bestellungMenue);

        //when
        $bestellungMenue->setMenge(2);
        self::$bestellungMenueRepository->save($bestellungMenue);

        $updatedBestellungMenue = self::$bestellungMenueRepository->getById($bestellungMenue->getId());

        //then
        $this->assertEquals(2, $updatedBestellungMenue->getMenge());
    }

    public function testGetAll(): void
    {
        //given
        $bestellungMenue = $this->createBestellungMenue("TestGetAll1");
        self::$bestellungMenueRepository->save($bestellungMenue);
        $bestellungMenue = $this->createBestellungMenue("TestGetAll2");
        self::$bestellungMenueRepository->save($bestellungMenue);
        $bestellungMenue = $this->createBestellungMenue("TestGetAll3");
        self::$bestellungMenueRepository->save($bestellungMenue);

        //when
        $allBestellungMenues = self::$bestellungMenueRepository->getAll();

        //then
        $this->assertCount(3, $allBestellungMenues);
    }

    public function testExists(): void
    {
        //given
        $bestellungMenue = $this->createBestellungMenue("TestExists1");
        self::$bestellungMenueRepository->save($bestellungMenue);

        //when
        $exists = self::$bestellungMenueRepository->exists($bestellungMenue->getId());
        $doesNotExist = self::$bestellungMenueRepository->exists(-1);

        //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
        //given
        $bestellungMenue = $this->createBestellungMenue("TestDelete1");
        self::$bestellungMenueRepository->save($bestellungMenue);
        $id = $bestellungMenue->getId();

        //when
        $deleted = self::$bestellungMenueRepository->deleteById($id);
        $stillExists = self::$bestellungMenueRepository->exists($id);

        //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
        //given
        $bestellungMenue = $this->createBestellungMenue("TestDeleteAll1");
        self::$bestellungMenueRepository->save($bestellungMenue);
        $bestellungMenue = $this->createBestellungMenue("TestDeleteAll2");
        self::$bestellungMenueRepository->save($bestellungMenue);
        $bestellungMenue = $this->createBestellungMenue("TestDeleteAll3");
        self::$bestellungMenueRepository->save($bestellungMenue);

        //when
        self::$bestellungMenueRepository->deleteAll();

        //then
        $this->assertEmpty(self::$bestellungMenueRepository->getAll());
    }
}