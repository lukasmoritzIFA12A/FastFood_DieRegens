<?php

namespace datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/ProduktRepositoryTest.php';

use datenbank\Entitaeten\Energiewert;
use datenbank\Repositories\EnergiewertRepository;
use DatenbankTest;

class EnergiewertRepositoryTest extends DatenbankTest
{
    private static EnergiewertRepository $energiewertRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$energiewertRepository =  new EnergiewertRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$energiewertRepository->deleteAll();
    }

    public static function createEnergiewert(): Energiewert
    {
        $produkt = ProduktRepositoryTest::createProdukt();

        $energiewert = new Energiewert();
        $energiewert->setProdukt($produkt);
        $energiewert->setPortionSize("1");
        $energiewert->setKalorien("500");
        $energiewert->setFett("20");
        $energiewert->setKohlenhydrate("50");
        $energiewert->setZucker("30");
        $energiewert->setEiweiss("10");
        return $energiewert;
    }

    public function testSaveByInsert(): void
    {
    //given
        $energiewert = $this->createEnergiewert();

    //when
        self::$energiewertRepository->save($energiewert);
        $savedEnergiewert = self::$energiewertRepository->getById($energiewert->getId());

    //then
        $this->assertInstanceOf(Energiewert::class, $savedEnergiewert);
        $this->assertEquals($energiewert->getPortionSize(), $savedEnergiewert->getPortionSize());
        $this->assertEquals($energiewert->getKalorien(), $savedEnergiewert->getKalorien());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);

    //when
        $energiewert->setPortionSize("500g");
        $energiewert->setKalorien("1000");
        self::$energiewertRepository->save($energiewert);

        $updatedEnergiewert = self::$energiewertRepository->getById($energiewert->getId());

    //then
        $this->assertEquals($energiewert->getPortionSize(), $updatedEnergiewert->getPortionSize());
        $this->assertEquals($energiewert->getKalorien(), $updatedEnergiewert->getKalorien());
    }

    public function testGetAll(): void
    {
    //given
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);

    //when
        $allEnergiewerte = self::$energiewertRepository->getAll();

    //then
        $this->assertCount(3, $allEnergiewerte);
    }

    public function testExists(): void
    {
    //given
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);

    //when
        $exists = self::$energiewertRepository->exists($energiewert->getId());
        $doesNotExist = self::$energiewertRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);
        $id = $energiewert->getId();

    //when
        $deleted = self::$energiewertRepository->deleteById($id);
        $stillExists = self::$energiewertRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);
        $energiewert = $this->createEnergiewert();
        self::$energiewertRepository->save($energiewert);

    //when
        self::$energiewertRepository->deleteAll();

    //then
        $this->assertEmpty(self::$energiewertRepository->getAll());
    }
}