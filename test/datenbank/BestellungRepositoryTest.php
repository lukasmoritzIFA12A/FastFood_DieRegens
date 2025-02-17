<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Entitaeten\Adresse;
use datenbank\Entitaeten\Bestellstatus;
use datenbank\Entitaeten\Bestellung;
use datenbank\Entitaeten\Icon;
use datenbank\Entitaeten\Kunde;
use datenbank\Entitaeten\Login;
use datenbank\Entitaeten\Menue;
use datenbank\Entitaeten\Produkt;
use datenbank\Entitaeten\Zahlungsart;
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

    /**
     * @throws ORMException
     */
    public function createAndSaveBestellung(string $LoginName): Bestellung
    {
        $adresse = new Adresse();
        $adresse->setStrassenname("Musterstr.");
        $adresse->setHausnummer("5");
        $adresse->setPlz("90115");
        $adresse->setStadt("Berlin");
        $adresse->setBundesland("Berlin");

        $login = new Login();
        $login->setNutzername($LoginName);
        $login->setPasswort("Geheim");

        $kunde = new Kunde();
        $kunde->setVorname("Max");
        $kunde->setNachname("Mustermann");
        $kunde->setRegistrierungsdatum(new DateTime("2023-01-01 10:00:00"));
        $kunde->setAdresse($adresse);
        $kunde->setLogin($login);

        $zahlungsart = new Zahlungsart();
        $zahlungsart->setArt("Kreditkarte");

        $bestellstatus = new Bestellstatus();
        $bestellstatus->setStatus("Neu");

        $icon = new Icon();
        $icon->setBildPfad("/pfad/zum/huhn.png");

        $produkt = new Produkt();
        $produkt->setTitel("Coca-Cola");
        $produkt->setPreis(1.5);
        $produkt->setLagerbestand(10);
        $produkt->setIcon($icon);
        $produkte = new ArrayCollection([$produkt]);

        $menue = new Menue();
        $menue->setTitel("Cooles Menue");
        $menue->setProdukte($produkte);
        $menues = new ArrayCollection([$menue]);

        $bestellung = new Bestellung();
        $bestellung->setBestellungDatum(new DateTime("2023-01-01 10:00:00"));
        $bestellung->setKunde($kunde);
        $bestellung->setZahlungsart($zahlungsart);
        $bestellung->setBestellstatus($bestellstatus);
        $bestellung->setMenues($menues);
        $bestellung->setProdukte($produkte);

        self::$bestellungRepository->save($bestellung);
        return $bestellung;
    }

    /**
     * @throws ORMException
     * @throws Exception
     */
    public function testSaveByInsert(): void
    {
    //when
        $bestellung = $this->createAndSaveBestellung("User1Insert");
        $savedBestellung = self::$bestellungRepository->getById($bestellung->getId());

    //then
        $this->assertInstanceOf(Bestellung::class, $savedBestellung);
        $this->assertEquals($bestellung->getKunde()->getVorname(), $savedBestellung->getKunde()->getVorname());
        $this->assertEquals($bestellung->getZahlungsart()->getArt(), $savedBestellung->getZahlungsart()->getArt());
        $this->assertEquals($bestellung->getBestellstatus()->getStatus(), $savedBestellung->getBestellstatus()->getStatus());
        $this->assertCount(1, $savedBestellung->getMenues());
        $this->assertCount(1, $savedBestellung->getProdukte());
    }

    /**
     * @throws ORMException
     * @throws Exception
     */
    public function testSaveByUpdate(): void
    {
    //given
        $bestellung = $this->createAndSaveBestellung("User1Update");

    //when
        $bestellung->getBestellstatus()->setStatus("Abgeschlossen");
        self::$bestellungRepository->save($bestellung);

        $updatedBestellung = self::$bestellungRepository->getById($bestellung->getId());

    //then
        $this->assertEquals($bestellung->getBestellstatus()->getStatus(), $updatedBestellung->getBestellstatus()->getStatus());
    }

    /**
     * @throws ORMException
     */
    public function testGetAll(): void
    {
    //given
        $this->createAndSaveBestellung("User1Get");
        $this->createAndSaveBestellung("User2Get");
        $this->createAndSaveBestellung("User3Get");

    //when
        $allBestellungen = self::$bestellungRepository->getAll();

    //then
        $this->assertCount(3, $allBestellungen);
    }

    /**
     * @throws ORMException
     */
    public function testExists(): void
    {
    //given
        $bestellung = $this->createAndSaveBestellung("User1Exists");

    //when
        $exists = self::$bestellungRepository->exists($bestellung->getId());
        $doesNotExist = self::$bestellungRepository->exists(-1);

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
        $bestellung = $this->createAndSaveBestellung("User1Delete");
        $id = $bestellung->getId();

    //when
        $deleted = self::$bestellungRepository->deleteById($id);
        $stillExists = self::$bestellungRepository->exists($id);

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
        $this->createAndSaveBestellung("User1DeleteAll");
        $this->createAndSaveBestellung("User2DeleteAll");
        $this->createAndSaveBestellung("User3DeleteAll");

    //when
        self::$bestellungRepository->deleteAll();

    //then
        $this->assertEmpty(self::$bestellungRepository->getAll());
    }
}