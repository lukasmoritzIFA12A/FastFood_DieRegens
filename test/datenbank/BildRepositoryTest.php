<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Bild;
use App\datenbank\Repositories\BildRepository;
use Test\DatenbankTest;

class BildRepositoryTest extends DatenbankTest
{
    private static BildRepository $iconRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$iconRepository =  new BildRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$iconRepository->deleteAll();
    }

    public static function createBild(): Bild
    {
        $bild = new Bild();
        $bild->setBild("BLOB");
        return $bild;
    }

    public function testSaveByInsert(): void
    {
    //given
        $icon = self::createBild();

    //when
        self::$iconRepository->save($icon);
        $savedIcon = self::$iconRepository->getById($icon->getId());

    //then
        $this->assertInstanceOf(Bild::class, $savedIcon);
        $this->assertEquals($icon->getBild(), $savedIcon->getBild());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $icon = self::createBild();
        self::$iconRepository->save($icon);

    //when
        $icon->setBild("ANDERER_BLOB");
        self::$iconRepository->save($icon);

        $updatedIcon = self::$iconRepository->getById($icon->getId());

    //then
        $this->assertInstanceOf(Bild::class, $updatedIcon);
        $this->assertEquals($icon->getBild(), $updatedIcon->getBild());
    }

    public function testGetAll(): void
    {
    //given
        $icon = self::createBild();
        self::$iconRepository->save($icon);
        $icon = self::createBild();
        self::$iconRepository->save($icon);
        $icon = self::createBild();
        self::$iconRepository->save($icon);

    //when
        $allIcons = self::$iconRepository->getAll();

    //then
        $this->assertCount(3, $allIcons);
    }

    public function testExists(): void
    {
    //given
        $icon = self::createBild();
        self::$iconRepository->save($icon);

    //when
        $exists = self::$iconRepository->exists($icon->getId());
        $doesNotExist = self::$iconRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $icon = self::createBild();
        self::$iconRepository->save($icon);
        $id = $icon->getId();

    //when
        $deleted = self::$iconRepository->deleteById($id);
        $stillExists = self::$iconRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $icon = self::createBild();
        self::$iconRepository->save($icon);
        $icon = self::createBild();
        self::$iconRepository->save($icon);
        $icon = self::createBild();
        self::$iconRepository->save($icon);

    //when
        self::$iconRepository->deleteAll();

    //then
        $this->assertEmpty(self::$iconRepository->getAll());
    }
}