<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Rabatt;
use App\datenbank\Repositories\RabattRepository;
use Test\DatenbankTest;

class RabattRepositoryTest extends DatenbankTest
{
    private static RabattRepository $rabattRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$rabattRepository = new RabattRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$rabattRepository->deleteAll();
    }

    public static function createRabatt($rabattCode): Rabatt
    {
        $rabatt = new Rabatt();
        $rabatt->setCode($rabattCode);
        $rabatt->setMinderung("24%");
        return $rabatt;
    }

    public function testSaveByInsert(): void
    {
        //given
        $rabatt = self::createRabatt("rabattInsert");

        //when
        self::$rabattRepository->save($rabatt);
        $savedRabatt = self::$rabattRepository->getById($rabatt->getId());

        //then
        $this->assertInstanceOf(Rabatt::class, $savedRabatt);
        $this->assertEquals($rabatt->getCode(), $savedRabatt->getCode());
        $this->assertEquals($rabatt->getMinderung(), $savedRabatt->getMinderung());
    }

    public function testSaveByUpdate(): void
    {
        //given
        $rabatt = self::createRabatt("rabattUpdate");
        self::$rabattRepository->save($rabatt);

        //when
        $rabatt->setCode("RABATT_UPDATED");
        $rabatt->setMinderung("20.00");
        self::$rabattRepository->save($rabatt);
        $updatedRabatt = self::$rabattRepository->getById($rabatt->getId());

        //then
        $this->assertInstanceOf(Rabatt::class, $updatedRabatt);
        $this->assertEquals($rabatt->getCode(), $updatedRabatt->getCode());
        $this->assertEquals($rabatt->getMinderung(), $updatedRabatt->getMinderung());
    }

    public function testGetAll(): void
    {
        //given
        $rabatt = self::createRabatt("rabattGet1");
        self::$rabattRepository->save($rabatt);
        $rabatt = self::createRabatt("rabattGet2");
        self::$rabattRepository->save($rabatt);
        $rabatt = self::createRabatt("rabattGet3");
        self::$rabattRepository->save($rabatt);

        //when
        $allRabatte = self::$rabattRepository->getAll();

        //then
        $this->assertCount(3, $allRabatte);
    }

    public function testExists(): void
    {
        //given
        $rabatt = self::createRabatt("rabattExists");
        self::$rabattRepository->save($rabatt);

        //when
        $exists = self::$rabattRepository->exists($rabatt->getId());
        $doesNotExist = self::$rabattRepository->exists(-1);

        //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
        //given
        $rabatt = self::createRabatt("rabattDeleteById");
        self::$rabattRepository->save($rabatt);
        $id = $rabatt->getId();

        //when
        $deleted = self::$rabattRepository->deleteById($id);
        $stillExists = self::$rabattRepository->exists($id);

        //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
        //given
        $rabatt = self::createRabatt("rabattDelete1");
        self::$rabattRepository->save($rabatt);
        $rabatt = self::createRabatt("rabattDelete2");
        self::$rabattRepository->save($rabatt);
        $rabatt = self::createRabatt("rabattDelete3");
        self::$rabattRepository->save($rabatt);

        //when
        self::$rabattRepository->deleteAll();

        //then
        $this->assertEmpty(self::$rabattRepository->getAll());
    }
}