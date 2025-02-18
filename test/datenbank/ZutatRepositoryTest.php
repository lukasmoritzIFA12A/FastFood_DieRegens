<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Zutat;
use App\datenbank\Repositories\ZutatRepository;
use Test\DatenbankTest;

class ZutatRepositoryTest extends DatenbankTest
{
    private static ZutatRepository $zutatRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$zutatRepository =  new ZutatRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$zutatRepository->deleteAll();
    }

    public static function createZutat(): Zutat
    {
        $zutat = new Zutat();
        $zutat->setZutatName("Milch");
        return $zutat;
    }

    public function testSaveByInsert(): void
    {
    //given
        $zutat = self::createZutat();

    //when
        self::$zutatRepository->save($zutat);
        $savedZutat = self::$zutatRepository->getById($zutat->getId());

    //then
        $this->assertInstanceOf(Zutat::class, $savedZutat);
        $this->assertEquals($zutat->getZutatName(), $savedZutat->getZutatName());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);

    //when
        $zutat->setZutatName("Butter");
        self::$zutatRepository->save($zutat);
        $updatedZutat = self::$zutatRepository->getById($zutat->getId());

    //then
        $this->assertInstanceOf(Zutat::class, $updatedZutat);
        $this->assertEquals($zutat->getZutatName(), $updatedZutat->getZutatName());
    }

    public function testGetAll(): void
    {
    //given
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);

    //when
        $allZutaten = self::$zutatRepository->getAll();

    //then
        $this->assertCount(3, $allZutaten);
    }

    public function testExists(): void
    {
    //given
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);

    //when
        $exists = self::$zutatRepository->exists($zutat->getId());
        $doesNotExist = self::$zutatRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);
        $id = $zutat->getId();

    //when
        $deleted = self::$zutatRepository->deleteById($id);
        $stillExists = self::$zutatRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);
        $zutat = self::createZutat();
        self::$zutatRepository->save($zutat);

    //when
        self::$zutatRepository->deleteAll();

    //then
        $this->assertEmpty(self::$zutatRepository->getAll());
    }
}