<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/LadespruecheRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\LadespruecheRepository;

class LadespruecheRepositoryTest extends DatenbankTest
{
    private static LadespruecheRepository $ladespruecheRepository;

    public static function setUpBeforeClass(): void
    {
        self::$ladespruecheRepository = new LadespruecheRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$ladespruecheRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $spruch = "Das ist ein Spruch";

        $insertedLadesprueche = self::$ladespruecheRepository->insert($spruch);

        $this->assertNotNull($insertedLadesprueche);
        $this->assertEquals($spruch, $insertedLadesprueche->getSpruch());
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        $spruch = "Das ist ein Spruch";

        self::$ladespruecheRepository->insert($spruch);
        self::$ladespruecheRepository->insert($spruch);

        self::$ladespruecheRepository->deleteAll();

        $ladesprueche = self::$ladespruecheRepository->getAll();
        $this->assertEmpty($ladesprueche);
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $spruch = "Das ist ein Spruch";

        $insertedLadesprueche = self::$ladespruecheRepository->insert($spruch);

        $retrievedLadesprueche = self::$ladespruecheRepository->getById($insertedLadesprueche->getId());

        $this->assertNotNull($retrievedLadesprueche);
        $this->assertEquals($insertedLadesprueche->getId(), $retrievedLadesprueche->getId());
    }

    protected function testGetAll(): void
    {
        // TODO: Implement testGetAll() method.
    }

    protected function testUpdate(): void
    {
        // TODO: Implement testUpdate() method.
    }

    protected function testDeleteById(): void
    {
        // TODO: Implement testDeleteById() method.
    }
}