<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Produkt;
use App\datenbank\Repositories\ProduktRepository;
use Test\DatenbankTest;

class ProduktRepositoryTest extends DatenbankTest
{
    private static ProduktRepository $produktRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$produktRepository =  new ProduktRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$produktRepository->deleteAll();
    }

    public static function createProdukt(): Produkt
    {
        $bild = BildRepositoryTest::createBild();

        $produkt = new Produkt();
        $produkt->setTitel("Coca-Cola");
        $produkt->setPreis(1.5);
        $produkt->setAusverkauft(false);
        $produkt->setBild($bild);
        return $produkt;
    }

    public function testSaveByInsert(): void
    {
    //given
        $produkt = self::createProdukt();

    //when
        self::$produktRepository->save($produkt);
        $savedProdukt = self::$produktRepository->getById($produkt->getId());

    //then
        $this->assertInstanceOf(Produkt::class, $savedProdukt);
        $this->assertEquals($produkt->getTitel(), $savedProdukt->getTitel());
        $this->assertEquals($produkt->getPreis(), $savedProdukt->getPreis());
        $this->assertEquals($produkt->isAusverkauft(), $savedProdukt->isAusverkauft());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);

    //when
        $produkt->setTitel("Sprite Zero");
        $produkt->setPreis(1.6);
        $produkt->setAusverkauft(true);
        self::$produktRepository->save($produkt);
        $updatedProdukt = self::$produktRepository->getById($produkt->getId());

    //then
        $this->assertInstanceOf(Produkt::class, $updatedProdukt);
        $this->assertEquals($produkt->getTitel(), $updatedProdukt->getTitel());
        $this->assertEquals($produkt->getPreis(), $updatedProdukt->getPreis());
        $this->assertEquals($produkt->isAusverkauft(), $updatedProdukt->isAusverkauft());
    }

    public function testGetAll(): void
    {
    //given
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);

    //when
        $allProdukte = self::$produktRepository->getAll();

    //then
        $this->assertCount(3, $allProdukte);
    }

    public function testExists(): void
    {
    //given
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);

    //when
        $exists = self::$produktRepository->exists($produkt->getId());
        $doesNotExist = self::$produktRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);
        $id = $produkt->getId();

    //when
        $deleted = self::$produktRepository->deleteById($id);
        $stillExists = self::$produktRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);

    //when
        self::$produktRepository->deleteAll();

    //then
        $this->assertEmpty(self::$produktRepository->getAll());
    }
}