<?php

include_once dirname(__DIR__) . '/datenbank/DatenbankAccess.php';

use PHPUnit\Framework\TestCase;

class DatenbankTest extends TestCase
{
    private static DatenbankAccess $datenbankAccess;

    protected static function cleanup(): void
    {
        error_log("Default Implementation von cleanup");
    }

    public static function setUpBeforeClass(): void
    {
        $configs = include dirname(__DIR__) . '/datenbank/Config.php';
        self::$datenbankAccess = new DatenbankAccess($configs['dbtestname']);

        static::cleanup();
    }

    protected function setUp(): void
    {
        static::cleanup();
    }

    protected static function closeDatenbankAccess(): void
    {
        self::$datenbankAccess->close();
    }
}