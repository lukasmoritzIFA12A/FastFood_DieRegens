<?php

namespace datenbank;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;

class EntityManagerFactory
{
    public static function createEntityManager(bool $isTestMode = false): EntityManager
    {
        $config = static::getMetadataConfiguration();
        $connection = static::getDriverConnection($config, $isTestMode);

        return new EntityManager($connection, $config);
    }

    private static function getDriverConnection(Configuration $configuration, bool $isTestMode = false) : Connection
    {
        $connectionParams = static::getConnectionParams($isTestMode);
        return DriverManager::getConnection($connectionParams, $configuration);
    }

    private static function getMetadataConfiguration(): Configuration
    {
        return ORMSetup::createAttributeMetadataConfiguration(
            paths: [dirname(__DIR__, 2) . '/src/datenbank/Entitaeten'],
            isDevMode: true,
        );
    }

    private static function getConnectionParams(bool $isTestMode = false): array
    {
        $datenbankConfig = include(dirname(__DIR__) . '/datenbank/Config.php');
        $host = $datenbankConfig['servername'];
        $user = $datenbankConfig['username'];
        $password = $datenbankConfig['password'];
        $dbname = static::getDatabaseName($isTestMode);

        $dsn = "mysqli://$user:$password@$host/$dbname";

        $dsnParser = new DsnParser();
        return $dsnParser->parse($dsn);
    }

    public static function updateSchema(EntityManager $entityManager): void
    {
        $schemaTool = new SchemaTool($entityManager);
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->updateSchema($classes);
    }

    public static function dropSchema(EntityManager $entityManager): void
    {
        $schemaTool = new SchemaTool($entityManager);
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool->dropSchema($classes);
    }

    public static function dumpSchemaToSQL(bool $isTestMode = false): void
    {
        $entityManager = static::createEntityManager($isTestMode);
        $schemaTool = new SchemaTool($entityManager);
        $classes = $entityManager->getMetadataFactory()->getAllMetadata();

        $databaseName = static::getDatabaseName($isTestMode);
        $sqlCreateDatabase = [ 'DROP DATABASE IF EXISTS '.$databaseName, 'CREATE DATABASE '.$databaseName, 'USE '.$databaseName ];
        $sqlCreateTable = $schemaTool->getCreateSchemaSql($classes);

        $sqls = array_merge($sqlCreateDatabase, $sqlCreateTable);

        $dir = "sql";
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file = $isTestMode ? "$dir/CREATE_FASTFOOD_TEST.sql" : "$dir/CREATE_FASTFOOD.sql";
        file_put_contents($file, implode(";\n", $sqls) . ";\n");

        echo "SQL-Statements wurden erfolgreich in $file gespeichert!🔥🚀\n";
    }

    public static function getDatabaseName(bool $isTestMode = false): string
    {
        $datenbankConfig = include(dirname(__DIR__) . '/datenbank/Config.php');
        return $isTestMode ? $datenbankConfig['dbtestname'] : $datenbankConfig['dbname'];
    }
}