<?php

namespace datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/BestellstatusRepositoryTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/AdresseRepositoryTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/KundeRepositoryTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/ZahlungsartRepositoryTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/ProduktRepositoryTest.php';
include_once dirname(__DIR__, 2) . '/test/Datenbank/MenueRepositoryTest.php';

use datenbank\Entitaeten\Bestellung;
use datenbank\Repositories\BestellungRepository;
use DatenbankTest;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Exception\ORMException;
use Exception;

class BestellungRepositoryTest extends DatenbankTest
{
    private static BestellungRepository $bestellungRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$bestellungRepository =  new BestellungRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$bestellungRepository->deleteAll();
    }

    public static function createBestellung(string $LoginName): Bestellung
    {
        $kunde = KundeRepositoryTest::createKunde($LoginName);
        $zahlungsart = ZahlungsartRepositoryTest::createZahlungsart();
        $bestellstatus = BestellstatusRepositoryTest::createBestellstatus();

        $produkt = ProduktRepositoryTest::createProdukt();
        $produkte = new ArrayCollection([$produkt]);

        $menue = MenueRepositoryTest::createMenue();
        $menues = new ArrayCollection([$menue]);

        $bestellung = new Bestellung();
        $bestellung->setBestellungDatum(new DateTime("2023-01-01 10:00:00"));
        $bestellung->setKunde($kunde);
        $bestellung->setZahlungsart($zahlungsart);
        $bestellung->setBestellstatus($bestellstatus);
        $bestellung->setMenues($menues);
        $bestellung->setProdukte($produkte);
        return $bestellung;
    }

    public function testSaveByInsert(): void
    {
    //when
        $bestellung = $this->createBestellung("User1Insert");
        self::$bestellungRepository->save($bestellung);
        $savedBestellung = self::$bestellungRepository->getById($bestellung->getId());

    //then
        $this->assertInstanceOf(Bestellung::class, $savedBestellung);
        $this->assertEquals($bestellung->getKunde()->getVorname(), $savedBestellung->getKunde()->getVorname());
        $this->assertEquals($bestellung->getZahlungsart()->getArt(), $savedBestellung->getZahlungsart()->getArt());
        $this->assertEquals($bestellung->getBestellstatus()->getStatus(), $savedBestellung->getBestellstatus()->getStatus());
        $this->assertCount(1, $savedBestellung->getMenues());
        $this->assertCount(1, $savedBestellung->getProdukte());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $bestellung = $this->createBestellung("User1Update");
        self::$bestellungRepository->save($bestellung);

    //when
        $bestellung->getBestellstatus()->setStatus("Abgeschlossen");
        self::$bestellungRepository->save($bestellung);

        $updatedBestellung = self::$bestellungRepository->getById($bestellung->getId());

    //then
        $this->assertEquals($bestellung->getBestellstatus()->getStatus(), $updatedBestellung->getBestellstatus()->getStatus());
    }

    public function testGetAll(): void
    {
    //given
        $bestellung = $this->createBestellung("User1Get");
        self::$bestellungRepository->save($bestellung);
        $bestellung = $this->createBestellung("User2Get");
        self::$bestellungRepository->save($bestellung);
        $bestellung = $this->createBestellung("User3Get");
        self::$bestellungRepository->save($bestellung);

    //when
        $allBestellungen = self::$bestellungRepository->getAll();

    //then
        $this->assertCount(3, $allBestellungen);
    }

    public function testExists(): void
    {
    //given
        $bestellung = $this->createBestellung("User1Exists");
        self::$bestellungRepository->save($bestellung);

    //when
        $exists = self::$bestellungRepository->exists($bestellung->getId());
        $doesNotExist = self::$bestellungRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $bestellung = $this->createBestellung("User1Delete");
        self::$bestellungRepository->save($bestellung);
        $id = $bestellung->getId();

    //when
        $deleted = self::$bestellungRepository->deleteById($id);
        $stillExists = self::$bestellungRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $bestellung = $this->createBestellung("User1DeleteAll");
        self::$bestellungRepository->save($bestellung);
        $bestellung = $this->createBestellung("User2DeleteAll");
        self::$bestellungRepository->save($bestellung);
        $bestellung = $this->createBestellung("User3DeleteAll");
        self::$bestellungRepository->save($bestellung);

    //when
        self::$bestellungRepository->deleteAll();

    //then
        $this->assertEmpty(self::$bestellungRepository->getAll());
    }
}