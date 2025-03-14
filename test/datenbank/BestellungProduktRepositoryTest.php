<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\BestellungProdukt;
use App\datenbank\Repositories\BestellungProduktRepository;
use Test\DatenbankTest;

class BestellungProduktRepositoryTest extends DatenbankTest
{
    private static BestellungProduktRepository $bestellungProduktRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$bestellungProduktRepository = new BestellungProduktRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$bestellungProduktRepository->deleteAll();
    }

    public static function createBestellungProdukt($loginName): BestellungProdukt
    {
        $bestellungProdukt = new BestellungProdukt();
        $bestellungProdukt->setMenge(1);
        $bestellungProdukt->setProdukt(ProduktRepositoryTest::createProdukt());
        $bestellungProdukt->setBestellung(BestellungRepositoryTest::createBestellung($loginName));
        return $bestellungProdukt;
    }

    public function testSaveByInsert(): void
    {
        //when
        $bestellungProdukt = $this->createBestellungProdukt("TestUser1");
        self::$bestellungProduktRepository->save($bestellungProdukt);
        $savedBestellungProdukt = self::$bestellungProduktRepository->getById($bestellungProdukt->getId());

        //then
        $this->assertInstanceOf(BestellungProdukt::class, $savedBestellungProdukt);
        $this->assertEquals($bestellungProdukt->getMenge(), $savedBestellungProdukt->getMenge());
    }

    public function testSaveByUpdate(): void
    {
        //given
        $bestellungProdukt = $this->createBestellungProdukt("TestUser2");
        self::$bestellungProduktRepository->save($bestellungProdukt);

        //when
        $bestellungProdukt->setMenge(2);
        self::$bestellungProduktRepository->save($bestellungProdukt);

        $updatedBestellungProdukt = self::$bestellungProduktRepository->getById($bestellungProdukt->getId());

        //then
        $this->assertEquals(2, $updatedBestellungProdukt->getMenge());
    }

    public function testGetAll(): void
    {
        //given
        $bestellungProdukt = $this->createBestellungProdukt("TestGetAll1");
        self::$bestellungProduktRepository->save($bestellungProdukt);
        $bestellungProdukt = $this->createBestellungProdukt("TestGetAll2");
        self::$bestellungProduktRepository->save($bestellungProdukt);
        $bestellungProdukt = $this->createBestellungProdukt("TestGetAll3");
        self::$bestellungProduktRepository->save($bestellungProdukt);

        //when
        $allBestellungProdukte = self::$bestellungProduktRepository->getAll();

        //then
        $this->assertCount(3, $allBestellungProdukte);
    }

    public function testExists(): void
    {
        //given
        $bestellungProdukt = $this->createBestellungProdukt("TestExists1");
        self::$bestellungProduktRepository->save($bestellungProdukt);

        //when
        $exists = self::$bestellungProduktRepository->exists($bestellungProdukt->getId());
        $doesNotExist = self::$bestellungProduktRepository->exists(-1);

        //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
        //given
        $bestellungProdukt = $this->createBestellungProdukt("TestDelete1");
        self::$bestellungProduktRepository->save($bestellungProdukt);
        $id = $bestellungProdukt->getId();

        //when
        $deleted = self::$bestellungProduktRepository->deleteById($id);
        $stillExists = self::$bestellungProduktRepository->exists($id);

        //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
        //given
        $bestellungProdukt = $this->createBestellungProdukt("TestDeleteAll1");
        self::$bestellungProduktRepository->save($bestellungProdukt);
        $bestellungProdukt = $this->createBestellungProdukt("TestDeleteAll2");
        self::$bestellungProduktRepository->save($bestellungProdukt);
        $bestellungProdukt = $this->createBestellungProdukt("TestDeleteAll3");
        self::$bestellungProduktRepository->save($bestellungProdukt);

        //when
        self::$bestellungProduktRepository->deleteAll();

        //then
        $this->assertEmpty(self::$bestellungProduktRepository->getAll());
    }
}