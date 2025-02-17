<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/test/DatenbankTest.php';

use datenbank\Entitaeten\Bestellstatus;
use datenbank\Repositories\BestellstatusRepository;
use DatenbankTest;
use Doctrine\ORM\Exception\ORMException;
use Exception;

class BestellstatusRepositoryTest extends DatenbankTest
{
    private static BestellstatusRepository $bestellstatusRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$bestellstatusRepository =  new BestellstatusRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$bestellstatusRepository->deleteAll();
    }

    /**
     * @throws ORMException
     */
    public function createAndSaveBestellstatus(string $status): Bestellstatus
    {
        $bestellstatus = new Bestellstatus();
        $bestellstatus->setStatus($status);

        self::$bestellstatusRepository->save($bestellstatus);
        return $bestellstatus;
    }

    /**
     * @throws ORMException
     * @throws Exception
     */
    public function testSaveByInsert(): void
    {
    //given
        $status = "In Bearbeitung";

    //when
        $bestellstatus = $this->createAndSaveBestellstatus($status);
        $savedStatus = self::$bestellstatusRepository->getById($bestellstatus->getId());

    //then
        $this->assertInstanceOf(Bestellstatus::class, $savedStatus);
        $this->assertEquals($status, $savedStatus->getStatus());
    }

    /**
     * @throws ORMException
     * @throws Exception
     */
    public function testSaveByUpdate(): void
    {
    //given
        $bestellstatus = $this->createAndSaveBestellstatus("Offen");

    //when
        $bestellstatus->setStatus("Abgeschlossen");
        self::$bestellstatusRepository->save($bestellstatus);

        $updatedStatus = self::$bestellstatusRepository->getById($bestellstatus->getId());

    //then
        $this->assertEquals("Abgeschlossen", $updatedStatus->getStatus());
    }

    /**
     * @throws ORMException
     */
    public function testGetAll(): void
    {
    //given
        $this->createAndSaveBestellstatus("Offen");
        $this->createAndSaveBestellstatus("In Bearbeitung");
        $this->createAndSaveBestellstatus("Abgeschlossen");

    //when
        $allStatuses = self::$bestellstatusRepository->getAll();

    //then
        $this->assertCount(3, $allStatuses);
    }

    /**
     * @throws ORMException
     */
    public function testExists(): void
    {
    //given
        $bestellstatus = $this->createAndSaveBestellstatus("Offen");

    //when
        $exists = self::$bestellstatusRepository->exists($bestellstatus->getId());
        $doesNotExist = self::$bestellstatusRepository->exists(-1);

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
        $bestellstatus = $this->createAndSaveBestellstatus("Offen");
        $id = $bestellstatus->getId();

    //when
        $deleted = self::$bestellstatusRepository->deleteById($id);
        $stillExists = self::$bestellstatusRepository->exists($id);

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
        $this->createAndSaveBestellstatus("Offen");
        $this->createAndSaveBestellstatus("In Bearbeitung");
        $this->createAndSaveBestellstatus("Abgeschlossen");

    //when
        self::$bestellstatusRepository->deleteAll();

    //then
        $this->assertEmpty(self::$bestellstatusRepository->getAll());
    }
}