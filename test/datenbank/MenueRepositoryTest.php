<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Menue;
use App\datenbank\Repositories\MenueRepository;
use Test\DatenbankTest;
use Doctrine\Common\Collections\ArrayCollection;

class MenueRepositoryTest extends DatenbankTest
{
    private static MenueRepository $menueRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$menueRepository =  new MenueRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$menueRepository->deleteAll();
    }

    public static function createMenue(): Menue
    {
        $produkt = ProduktRepositoryTest::createProdukt();
        $produkte = new ArrayCollection([$produkt]);

        $menue = new Menue();
        $menue->setTitel("Cooles Menue");
        $menue->setProdukte($produkte);
        return $menue;
    }

    public function testSaveByInsert(): void
    {
    //given
        $menue = self::createMenue();

    //when
        self::$menueRepository->save($menue);
        $savedMenue = self::$menueRepository->getById($menue->getId());

    //then
        $this->assertInstanceOf(Menue::class, $savedMenue);
        $this->assertEquals($menue->getTitel(), $savedMenue->getTitel());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $menue = self::createMenue();
        self::$menueRepository->save($menue);

    //when
        $menue->setTitel("Updated Menue");
        self::$menueRepository->save($menue);
        $updatedMenue = self::$menueRepository->getById($menue->getId());

    //then
        $this->assertInstanceOf(Menue::class, $updatedMenue);
        $this->assertEquals($menue->getTitel(), $updatedMenue->getTitel());
    }

    public function testGetAll(): void
    {
    //given
        $menue = self::createMenue();
        self::$menueRepository->save($menue);
        $menue = self::createMenue();
        self::$menueRepository->save($menue);
        $menue = self::createMenue();
        self::$menueRepository->save($menue);

    //when
        $allMenues = self::$menueRepository->getAll();

    //then
        $this->assertCount(3, $allMenues);
    }

    public function testExists(): void
    {
    //given
        $menue = self::createMenue();
        self::$menueRepository->save($menue);

    //when
        $exists = self::$menueRepository->exists($menue->getId());
        $doesNotExist = self::$menueRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $menue = self::createMenue();
        self::$menueRepository->save($menue);
        $id = $menue->getId();

    //when
        $deleted = self::$menueRepository->deleteById($id);
        $stillExists = self::$menueRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $menue = self::createMenue();
        self::$menueRepository->save($menue);
        $menue = self::createMenue();
        self::$menueRepository->save($menue);
        $menue = self::createMenue();
        self::$menueRepository->save($menue);

    //when
        self::$menueRepository->deleteAll();

    //then
        $this->assertEmpty(self::$menueRepository->getAll());
    }
}