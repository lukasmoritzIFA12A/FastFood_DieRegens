<?php

namespace Test\Datenbank;

include_once dirname(__DIR__, 2) . '/datenbank/Repositories/IconRepository.php';
include_once dirname(__DIR__) . '/DatenbankTest.php';

use DatenbankTest;
use RedBeanPHP\RedException\SQL;
use src\datenbank\Repositories\IconRepository;

class IconRepositoryTest extends DatenbankTest
{
    private static IconRepository $iconRepository;

    public static function setUpBeforeClass(): void
    {
        self::$iconRepository = new IconRepository();

        parent::setUpBeforeClass();
    }

    protected static function cleanup(): void
    {
        self::$iconRepository->deleteAll();
    }

    /**
     * @throws SQL
     */
    public function testInsert(): void
    {
        $bildpfad = "Pfad/Zum/Huhn";

        $insertedIcon = self::$iconRepository->insert($bildpfad);

        $this->assertNotNull($insertedIcon);
        $this->assertEquals($bildpfad, $insertedIcon->getBildPfad());
    }

    /**
     * @throws SQL
     */
    public function testDeleteAll(): void
    {
        $bildpfad = "Pfad/Zum/Huhn";

        self::$iconRepository->insert($bildpfad);
        self::$iconRepository->insert($bildpfad);

        self::$iconRepository->deleteAll();

        $icons = self::$iconRepository->getAll();
        $this->assertEmpty($icons);
    }

    /**
     * @throws SQL
     */
    public function testGetById(): void
    {
        $bildpfad = "Pfad/Zum/Huhn";

        $insertedIcon = self::$iconRepository->insert($bildpfad);

        $retrievedIcon = self::$iconRepository->getById($insertedIcon->getId());

        $this->assertNotNull($retrievedIcon);
        $this->assertEquals($insertedIcon->getId(), $retrievedIcon->getId());
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