<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Entitaeten\Adresse;
use datenbank\Repositories\AdresseRepository;
use DatenbankTest;
use Doctrine\ORM\Exception\ORMException;
use Exception;

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

    /**
     * @throws ORMException
     */
    public function createAndSaveAdresse(string $Strassenname): Adresse
    {
        $adresse = new Adresse();
        $adresse->setStrassenname($Strassenname);
        $adresse->setHausnummer("1");
        $adresse->setZusatz(null);
        $adresse->setPlz("10115");
        $adresse->setStadt("Berlin");
        $adresse->setBundesland("Berlin");

        self::$adresseRepository->save($adresse);
        return $adresse;
    }

    /**
     * @throws ORMException
     * @throws Exception
     */
    public function testSaveByInsert(): void
    {
    //given
        $Strassenname = "Existenzstraße";

    //when
        $adresse = $this->createAndSaveAdresse($Strassenname);
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

    /**
     * @throws ORMException
     * @throws Exception
     */
    public function testSaveByUpdate(): void
    {
    //given
        $adresse = $this->createAndSaveAdresse("Beispielstraße 2");

    //when
        $adresse->setStrassenname("Neue Straße 123");
        self::$adresseRepository->save($adresse);

        $updatedAdresse = self::$adresseRepository->getById($adresse->getId());

    //then
        $this->assertEquals($adresse->getStrassenname(), $updatedAdresse->getStrassenname());
    }

    /**
     * @throws ORMException
     */
    public function testGetAll(): void
    {
    //given
        for ($i = 1; $i <= 3; $i++) {
            $this->createAndSaveAdresse("Teststraße $i");
        }

    //when
        $adressen = self::$adresseRepository->getAll();

    //then
        $this->assertCount(3, $adressen);
    }

    /**
     * @throws ORMException
     */
    public function testExists(): void
    {
    //given
        $adresse = $this->createAndSaveAdresse("Existenzstraße");

    //when
        $exists = self::$adresseRepository->exists($adresse->getId());
        $doesNotExist = self::$adresseRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    /**
     * @throws ORMException
     */
    public function testDeleteById(): void
    {
    //given
        $adresse = $this->createAndSaveAdresse("Löschstraße");
        $id = $adresse->getId();

        //when
        $deleted = self::$adresseRepository->deleteById($id);
        $stillExists = self::$adresseRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    /**
     * @throws ORMException
     */
    public function testDeleteAll(): void
    {
    //given
        for ($i = 1; $i <= 3; $i++) {
            $this->createAndSaveAdresse("Teststraße $i");
        }

    //when
        self::$adresseRepository->deleteAll();

    //then
        $this->assertEmpty(self::$adresseRepository->getAll());
    }
}
