<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Bestellstatus;
use App\datenbank\Repositories\BestellstatusRepository;
use Test\DatenbankTest;

class BestellstatusRepositoryTest extends DatenbankTest
{
    private static BestellstatusRepository $bestellstatusRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$bestellstatusRepository =  new BestellstatusRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$bestellstatusRepository->deleteAll();
    }

    public static function createBestellstatus(): Bestellstatus
    {
        $bestellstatus = new Bestellstatus();
        $bestellstatus->setStatus("Offen");
        $bestellstatus->setFarbe("#FF0000");
        return $bestellstatus;
    }

    public function testSaveByInsert(): void
    {
    //when
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);
        $savedStatus = self::$bestellstatusRepository->getById($bestellstatus->getId());

    //then
        $this->assertInstanceOf(Bestellstatus::class, $savedStatus);
        $this->assertEquals($bestellstatus->getStatus(), $savedStatus->getStatus());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);

    //when
        $bestellstatus->setStatus("Abgeschlossen");
        self::$bestellstatusRepository->save($bestellstatus);

        $updatedStatus = self::$bestellstatusRepository->getById($bestellstatus->getId());

    //then
        $this->assertEquals("Abgeschlossen", $updatedStatus->getStatus());
    }

    public function testGetAll(): void
    {
    //given
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);

    //when
        $allStatuses = self::$bestellstatusRepository->getAll();

    //then
        $this->assertCount(3, $allStatuses);
    }

    public function testExists(): void
    {
    //given
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);

    //when
        $exists = self::$bestellstatusRepository->exists($bestellstatus->getId());
        $doesNotExist = self::$bestellstatusRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);
        $id = $bestellstatus->getId();

    //when
        $deleted = self::$bestellstatusRepository->deleteById($id);
        $stillExists = self::$bestellstatusRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);
        $bestellstatus = $this->createBestellstatus();
        self::$bestellstatusRepository->save($bestellstatus);

    //when
        self::$bestellstatusRepository->deleteAll();

    //then
        $this->assertEmpty(self::$bestellstatusRepository->getAll());
    }
}