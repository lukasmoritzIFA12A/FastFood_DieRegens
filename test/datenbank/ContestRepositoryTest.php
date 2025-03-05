<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Contest;
use App\datenbank\Repositories\ContestRepository;
use Test\DatenbankTest;

class ContestRepositoryTest extends DatenbankTest
{
    private static ContestRepository $contestRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$contestRepository =  new ContestRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$contestRepository->deleteAll();
    }

    public static function createContest(string $loginName): Contest
    {
        $bestellung = BestellungRepositoryTest::createBestellung($loginName);
        $bild = BildRepositoryTest::createBild();

        $contest = new Contest();
        $contest->setBild($bild);
        $contest->setBestellung($bestellung);
        $contest->setFreigeschalten(false);
        return $contest;
    }

    public function testSaveByInsert(): void
    {
    //when
        $contest = self::createContest("UserSaveInsert");
        self::$contestRepository->save($contest);
        $savedContest = self::$contestRepository->getById($contest->getId());

    //then
        $this->assertInstanceOf(Contest::class, $savedContest);
        $this->assertEquals($contest->getBild(), $savedContest->getBild());
        $this->assertEquals($contest->getBestellung()->getId(), $savedContest->getBestellung()->getId());
        $this->assertEquals($contest->isFreigeschalten(), $savedContest->isFreigeschalten());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $contest = self::createContest("UserSaveUpdate");
        self::$contestRepository->save($contest);

    //when
        $contest->getBild()->setBild("ANDERER_BLOB");
        self::$contestRepository->save($contest);

        $updatedContest = self::$contestRepository->getById($contest->getId());

    //then
        $this->assertEquals($contest->getBild()->getBild(), $updatedContest->getBild()->getBild());
    }

    public function testGetAll(): void
    {
    //given
        $contest = self::createContest("UserGet1");
        self::$contestRepository->save($contest);
        $contest = self::createContest("UserGet2");
        self::$contestRepository->save($contest);

    //when
        $allContests = self::$contestRepository->getAll();

    //then
        $this->assertCount(2, $allContests);
    }

    public function testExists(): void
    {
    //given
        $contest = self::createContest("UserExists");
        self::$contestRepository->save($contest);

    //when
        $exists = self::$contestRepository->exists($contest->getId());
        $doesNotExist = self::$contestRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $contest = self::createContest("UserDelete");
        self::$contestRepository->save($contest);
        $id = $contest->getId();

    //when
        $deleted = self::$contestRepository->deleteById($id);
        $stillExists = self::$contestRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $contest = self::createContest("UserDeleteAll1");
        self::$contestRepository->save($contest);
        $contest = self::createContest("UserDeleteAll2");
        self::$contestRepository->save($contest);

    //when
        self::$contestRepository->deleteAll();

    //then
        $this->assertEmpty(self::$contestRepository->getAll());
    }
}