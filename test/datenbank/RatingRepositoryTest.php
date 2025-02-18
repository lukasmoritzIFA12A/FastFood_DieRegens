<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Rating;
use App\datenbank\Repositories\RatingRepository;
use Test\DatenbankTest;

class RatingRepositoryTest extends DatenbankTest
{
    private static RatingRepository $ratingRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$ratingRepository =  new RatingRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$ratingRepository->deleteAll();
    }

    public static function createRating(string $login1, string $login2): Rating
    {
        $rating = new Rating();
        $rating->setRating(5);

        $contest = ContestRepositoryTest::createContest($login1);
        $rating->setContest($contest);

        $kunde = KundeRepositoryTest::createKunde($login2);
        $rating->setKunde($kunde);
        return $rating;
    }

    public function testSaveByInsert(): void
    {
    //given
        $rating = self::createRating("UserInsert1", "UserInsert2");

    //when
        self::$ratingRepository->save($rating);
        $savedRating = self::$ratingRepository->getById($rating->getId());

    //then
        $this->assertInstanceOf(Rating::class, $savedRating);
        $this->assertEquals($rating->getRating(), $savedRating->getRating());
        $this->assertEquals($rating->getContest()->getId(), $savedRating->getContest()->getId());
        $this->assertEquals($rating->getKunde()->getId(), $savedRating->getKunde()->getId());
    }

    public function testSaveByUpdate(): void
    {
    //given
        $rating = self::createRating("UserUpdate1", "UserUpdate2");
        self::$ratingRepository->save($rating);

    //when
        $rating->setRating(3);
        self::$ratingRepository->save($rating);
        $updatedRating = self::$ratingRepository->getById($rating->getId());

    //then
        $this->assertInstanceOf(Rating::class, $updatedRating);
        $this->assertEquals($rating->getRating(), $updatedRating->getRating());
        $this->assertEquals($rating->getContest()->getId(), $updatedRating->getContest()->getId());
        $this->assertEquals($rating->getKunde()->getId(), $updatedRating->getKunde()->getId());
    }

    public function testGetAll(): void
    {
    //given
        $rating = self::createRating("UserGetAll1", "UserGetAll2");
        self::$ratingRepository->save($rating);
        $rating = self::createRating("UserGetAll3", "UserGetAll4");
        self::$ratingRepository->save($rating);
        $rating = self::createRating("UserGetAll5", "UserGetAll6");
        self::$ratingRepository->save($rating);

    //when
        $allRatings = self::$ratingRepository->getAll();

    //then
        $this->assertCount(3, $allRatings);
    }

    public function testExists(): void
    {
    //given
        $rating = self::createRating("UserExists1", "UserExists2");
        self::$ratingRepository->save($rating);

    //when
        $exists = self::$ratingRepository->exists($rating->getId());
        $doesNotExist = self::$ratingRepository->exists(-1);

    //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
    //given
        $rating = self::createRating("UserDelete1", "UserDelete2");
        self::$ratingRepository->save($rating);
        $id = $rating->getId();

    //when
        $deleted = self::$ratingRepository->deleteById($id);
        $stillExists = self::$ratingRepository->exists($id);

    //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
    //given
        $rating = self::createRating("UserDeleteAll1", "UserDeleteAll2");
        self::$ratingRepository->save($rating);
        $rating = self::createRating("UserDeleteAll3", "UserDeleteAll4");
        self::$ratingRepository->save($rating);
        $rating = self::createRating("UserDeleteAll5", "UserDeleteAll6");
        self::$ratingRepository->save($rating);

    //when
        self::$ratingRepository->deleteAll();

    //then
        $this->assertEmpty(self::$ratingRepository->getAll());
    }
}