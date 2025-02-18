<?php

namespace datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/IconRepositoryTest.php';

use datenbank\Entitaeten\Produkt;
use datenbank\Repositories\ProduktRepository;
use DatenbankTest;
use Doctrine\ORM\Exception\ORMException;
use Exception;

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
        $icon = IconRepositoryTest::createIcon();

        $produkt = new Produkt();
        $produkt->setTitel("Coca-Cola");
        $produkt->setPreis(1.5);
        $produkt->setLagerbestand(10);
        $produkt->setIcon($icon);
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
        $this->assertEquals($produkt->getLagerbestand(), $savedProdukt->getLagerbestand());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $produkt = self::createProdukt();
        self::$produktRepository->save($produkt);

    //when
        $produkt->setTitel("Sprite Zero");
        $produkt->setPreis(1.6);
        $produkt->setLagerbestand(25);
        self::$produktRepository->save($produkt);
        $updatedProdukt = self::$produktRepository->getById($produkt->getId());

    //then
        $this->assertInstanceOf(Produkt::class, $updatedProdukt);
        $this->assertEquals($produkt->getTitel(), $updatedProdukt->getTitel());
        $this->assertEquals($produkt->getPreis(), $updatedProdukt->getPreis());
        $this->assertEquals($produkt->getLagerbestand(), $updatedProdukt->getLagerbestand());
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