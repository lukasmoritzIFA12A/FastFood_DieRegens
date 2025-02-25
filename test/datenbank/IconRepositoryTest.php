<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Icon;
use App\datenbank\Repositories\IconRepository;
use Test\DatenbankTest;

class IconRepositoryTest extends DatenbankTest
{
    private static IconRepository $iconRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$iconRepository =  new IconRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$iconRepository->deleteAll();
    }

    public static function createIcon(): Icon
    {
        $icon = new Icon();
        $icon->setBildPfad("bild/zum/icon.png");
        return $icon;
    }

    public function testSaveByInsert(): void
    {
    //given
        $icon = self::createIcon();

    //when
        self::$iconRepository->save($icon);
        $savedIcon = self::$iconRepository->getById($icon->getId());

    //then
        $this->assertInstanceOf(Icon::class, $savedIcon);
        $this->assertEquals($icon->getBildPfad(), $savedIcon->getBildPfad());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $icon = self::createIcon();
        self::$iconRepository->save($icon);

    //when
        $icon->setBildPfad("/pfad/zum/aktualisierten_bild.png");
        self::$iconRepository->save($icon);

        $updatedIcon = self::$iconRepository->getById($icon->getId());

    //then
        $this->assertInstanceOf(Icon::class, $updatedIcon);
        $this->assertEquals($icon->getBildPfad(), $updatedIcon->getBildPfad());
    }

    public function testGetAll(): void
    {
    //given
        $icon = self::createIcon();
        self::$iconRepository->save($icon);
        $icon = self::createIcon();
        self::$iconRepository->save($icon);
        $icon = self::createIcon();
        self::$iconRepository->save($icon);

    //when
        $allIcons = self::$iconRepository->getAll();

    //then
        $this->assertCount(3, $allIcons);
    }

    public function testExists(): void
    {
    //given
        $icon = self::createIcon();
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
        $icon = self::createIcon();
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
        $icon = self::createIcon();
        self::$iconRepository->save($icon);
        $icon = self::createIcon();
        self::$iconRepository->save($icon);
        $icon = self::createIcon();
        self::$iconRepository->save($icon);

    //when
        self::$iconRepository->deleteAll();

    //then
        $this->assertEmpty(self::$iconRepository->getAll());
    }
}