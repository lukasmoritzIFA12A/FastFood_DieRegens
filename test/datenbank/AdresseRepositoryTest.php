<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Adresse;
use App\datenbank\Repositories\AdresseRepository;
use Test\DatenbankTest;

class AdresseRepositoryTest extends DatenbankTest
{
    private static AdresseRepository $adresseRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();
        self::$adresseRepository = new AdresseRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$adresseRepository->deleteAll();
    }

    public static function createAdresse(): Adresse
    {
        $adresse = new Adresse();
        $adresse->setStrassenname("Existenzstraße");
        $adresse->setHausnummer("1");
        $adresse->setZusatz(null);
        $adresse->setPlz("10115");
        $adresse->setStadt("Berlin");
        $adresse->setBundesland("Berlin");
        return $adresse;
    }

    public function testSaveByInsert(): void
    {
    //when
        $adresse = $this->createAdresse();
        self::$adresseRepository->save($adresse);
        $savedAdresse = self::$adresseRepository->getById($adresse->getId());

    //then
        $this->assertInstanceOf(Adresse::class, $savedAdresse);
        $this->assertEquals($adresse->getStrassenname(), $savedAdresse->getStrassenname());
        $this->assertEquals($adresse->getHausnummer(), $savedAdresse->getHausnummer());
        $this->assertEquals($adresse->getZusatz(), $savedAdresse->getZusatz());
        $this->assertEquals($adresse->getPlz(), $savedAdresse->getPlz());
        $this->assertEquals($adresse->getStadt(), $savedAdresse->getStadt());
        $this->assertEquals($adresse->getBundesland(), $savedAdresse->getBundesland());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $adresse = $this->createAdresse();
        self::$adresseRepository->save($adresse);

    //when
        $adresse->setStrassenname("Neue Straße 123");
        self::$adresseRepository->save($adresse);

        $updatedAdresse = self::$adresseRepository->getById($adresse->getId());

    //then
        $this->assertEquals($adresse->getStrassenname(), $updatedAdresse->getStrassenname());
    }

    public function testGetAll(): void
    {
    //given
        for ($i = 1; $i <= 3; $i++) {
            $adresse = $this->createAdresse();
            self::$adresseRepository->save($adresse);
        }

    //when
        $adressen = self::$adresseRepository->getAll();

    //then
        $this->assertCount(3, $adressen);
    }

    public function testExists(): void
    {
    //given
        $adresse = $this->createAdresse();
        self::$adresseRepository->save($adresse);

    //when
        $exists = self::$adresseRepository->exists($adresse->getId());
        $doesNotExist = self::$adresseRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $adresse = $this->createAdresse();
        self::$adresseRepository->save($adresse);
        $id = $adresse->getId();

    //when
        $deleted = self::$adresseRepository->deleteById($id);
        $stillExists = self::$adresseRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        for ($i = 1; $i <= 3; $i++) {
            $adresse = $this->createAdresse();
            self::$adresseRepository->save($adresse);
        }

    //when
        self::$adresseRepository->deleteAll();

    //then
        $this->assertEmpty(self::$adresseRepository->getAll());
    }
}
