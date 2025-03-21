<?php

namespace Test\datenbank;

use App\datenbank\Entitaeten\Postbox;
use App\datenbank\Repositories\PostboxRepository;
use DateTime;
use Test\DatenbankTest;

class PostboxRepositoryTest extends DatenbankTest
{
    private static PostboxRepository $postboxRepository;

    public static function setUpBeforeClass(): void
    {
        $entityManager = parent::createEntityManager();

        self::$postboxRepository =  new PostboxRepository($entityManager);
    }

    protected static function cleanup(): void
    {
        self::$postboxRepository->deleteAll();
    }

    public static function createPostbox($loginName): Postbox
    {
        $postbox = new Postbox();
        $postbox->setNachricht("Eine Nachricht");
        $postbox->setNachrichtDatum(new DateTime());
        $postbox->setKunde(KundeRepositoryTest::createKunde($loginName));
        $postbox->setGelesen(false);
        return $postbox;
    }

    public function testSaveByInsert(): void
    {
        //given
        $postbox = self::createPostbox("TestInsert");

        //when
        self::$postboxRepository->save($postbox);
        $savedPostbox = self::$postboxRepository->getById($postbox->getId());

        //then
        $this->assertInstanceOf(Postbox::class, $savedPostbox);
        $this->assertEquals($postbox->getNachricht(), $savedPostbox->getNachricht());
    }

    public function testSaveByUpdate(): void
    {
        //given
        $postbox = self::createPostbox("TestUpdate");
        self::$postboxRepository->save($postbox);

        //when
        $postbox->setNachricht("Das ist eine aktualisierte Nachricht");
        self::$postboxRepository->save($postbox);

        $updatedPostbox = self::$postboxRepository->getById($postbox->getId());

        //then
        $this->assertInstanceOf(Postbox::class, $updatedPostbox);
        $this->assertEquals($postbox->getNachricht(), $updatedPostbox->getNachricht());
    }

    public function testGetAll(): void
    {
        //given
        $postbox = self::createPostbox("GetAll1");
        self::$postboxRepository->save($postbox);
        $postbox = self::createPostbox("GetAll2");
        self::$postboxRepository->save($postbox);
        $postbox = self::createPostbox("GetAll3");
        self::$postboxRepository->save($postbox);

        //when
        $allPostbox = self::$postboxRepository->getAll();

        //then
        $this->assertCount(3, $allPostbox);
    }

    public function testExists(): void
    {
        //given
        $postbox = self::createPostbox("TestExists");
        self::$postboxRepository->save($postbox);

        //when
        $exists = self::$postboxRepository->exists($postbox->getId());
        $doesNotExist = self::$postboxRepository->exists(-1);

        //then
        $this->assertTrue($exists);
        $this->assertFalse($doesNotExist);
    }

    public function testDeleteById(): void
    {
        //given
        $postbox = self::createPostbox("TestDelete");
        self::$postboxRepository->save($postbox);
        $id = $postbox->getId();

        //when
        $deleted = self::$postboxRepository->deleteById($id);
        $stillExists = self::$postboxRepository->exists($id);

        //then
        $this->assertTrue($deleted);
        $this->assertFalse($stillExists);
    }

    public function testDeleteAll(): void
    {
        //given
        $postbox = self::createPostbox("Delete1");
        self::$postboxRepository->save($postbox);
        $postbox = self::createPostbox("Delete2");
        self::$postboxRepository->save($postbox);
        $postbox = self::createPostbox("Delete3");
        self::$postboxRepository->save($postbox);

        //when
        self::$postboxRepository->deleteAll();

        //then
        $this->assertEmpty(self::$postboxRepository->getAll());
    }
}