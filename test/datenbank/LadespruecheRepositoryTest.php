<?php

namespace datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Entitaeten\Ladesprueche;
use datenbank\Repositories\LadespruecheRepository;
use DatenbankTest;

class LadespruecheRepositoryTest extends DatenbankTest
{
    private static LadespruecheRepository $ladespruecheRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$ladespruecheRepository =  new LadespruecheRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$ladespruecheRepository->deleteAll();
    }

    public static function createLadesprueche(): Ladesprueche
    {
        $ladesprueche = new Ladesprueche();
        $ladesprueche->setSpruch("Das ist ja ein cooler Spruch");
        return $ladesprueche;
    }

    public function testSaveByInsert(): void
    {
    //given
        $ladesprueche = self::createLadesprueche();

    //when
        self::$ladespruecheRepository->save($ladesprueche);
        $savedSpruch = self::$ladespruecheRepository->getById($ladesprueche->getId());

    //then
        $this->assertInstanceOf(Ladesprueche::class, $savedSpruch);
        $this->assertEquals($ladesprueche->getSpruch(), $savedSpruch->getSpruch());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);

    //when
        $ladesprueche->setSpruch("Das ist ein aktualisierter Spruch");
        self::$ladespruecheRepository->save($ladesprueche);

        $updatedSpruch = self::$ladespruecheRepository->getById($ladesprueche->getId());

    //then
        $this->assertInstanceOf(Ladesprueche::class, $updatedSpruch);
        $this->assertEquals($ladesprueche->getSpruch(), $updatedSpruch->getSpruch());
    }

    public function testGetAll(): void
    {
    //given
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);

    //when
        $allSprueche = self::$ladespruecheRepository->getAll();

    //then
        $this->assertCount(3, $allSprueche);
    }

    public function testExists(): void
    {
    //given
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);

    //when
        $exists = self::$ladespruecheRepository->exists($ladesprueche->getId());
        $doesNotExist = self::$ladespruecheRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);
        $id = $ladesprueche->getId();

    //when
        $deleted = self::$ladespruecheRepository->deleteById($id);
        $stillExists = self::$ladespruecheRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);
        $ladesprueche = self::createLadesprueche();
        self::$ladespruecheRepository->save($ladesprueche);

    //when
        self::$ladespruecheRepository->deleteAll();

    //then
        $this->assertEmpty(self::$ladespruecheRepository->getAll());
    }
}