<?php

namespace datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/IconRepositoryTest.php';

use datenbank\Entitaeten\Zahlungsart;
use datenbank\Repositories\ZahlungsartRepository;
use DatenbankTest;

class ZahlungsartRepositoryTest extends DatenbankTest
{
    private static ZahlungsartRepository $zahlungsartRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$zahlungsartRepository =  new ZahlungsartRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$zahlungsartRepository->deleteAll();
    }

    public static function createZahlungsart(): Zahlungsart
    {
        $zahlungsart = new Zahlungsart();
        $zahlungsart->setArt("Kreditkarte");
        return $zahlungsart;
    }

    public function testSaveByInsert(): void
    {
    //given
        $zahlungsart = self::createZahlungsart();

    //when
        self::$zahlungsartRepository->save($zahlungsart);
        $savedZahlungsart = self::$zahlungsartRepository->getById($zahlungsart->getId());

    //then
        $this->assertInstanceOf(Zahlungsart::class, $savedZahlungsart);
        $this->assertEquals($zahlungsart->getArt(), $savedZahlungsart->getArt());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);

    //when
        $zahlungsart->setArt("Debitkarte");
        self::$zahlungsartRepository->save($zahlungsart);
        $updatedZahlungsart = self::$zahlungsartRepository->getById($zahlungsart->getId());

    //then
        $this->assertInstanceOf(Zahlungsart::class, $updatedZahlungsart);
        $this->assertEquals($zahlungsart->getArt(), $updatedZahlungsart->getArt());
    }

    public function testGetAll(): void
    {
    //given
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);

    //when
        $allZahlungsarten = self::$zahlungsartRepository->getAll();

    //then
        $this->assertCount(3, $allZahlungsarten);
    }

    public function testExists(): void
    {
    //given
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);

    //when
        $exists = self::$zahlungsartRepository->exists($zahlungsart->getId());
        $doesNotExist = self::$zahlungsartRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);
        $id = $zahlungsart->getId();

    //when
        $deleted = self::$zahlungsartRepository->deleteById($id);
        $stillExists = self::$zahlungsartRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);
        $zahlungsart = self::createZahlungsart();
        self::$zahlungsartRepository->save($zahlungsart);

    //when
        self::$zahlungsartRepository->deleteAll();

    //then
        $this->assertEmpty(self::$zahlungsartRepository->getAll());
    }
}