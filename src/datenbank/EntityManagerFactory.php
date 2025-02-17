<?php

namespace datenbank;

use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;

class EntityManagerFactory
{
    public static function createEntityManager(bool $isTestMode = false): EntityManager
    {
        $datenbankConfig = include(dirname(__DIR__) . '/datenbank/Config.php');

        $config = ORMSetup::createAttributeMetadataConfiguration(
            paths: [dirname(__DIR__, 2) . '/src/datenbank/Entitaeten'],
            isDevMode: true,
        );

        $host = $datenbankConfig['servername'];
        $user = $datenbankConfig['username'];
        $password = $datenbankConfig['password'];
        $dbname = static::getDatabaseName($isTestMode);

        $dsn = "mysqli://$user:$password@$host/$dbname";

        $dsnParser = new DsnParser();
        $connectionParams = $dsnParser->parse($dsn);
        $connection = DriverManager::getConnection($connectionParams, $config);

        return new EntityManager($connection, $config);
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

        $file = $isTestMode ? 'sql/CREATE_FASTFOOD_TEST.sql' : 'sql/CREATE_FASTFOOD.sql';
        file_put_contents($file, implode(";\n", $sqls) . ";\n");

        echo "SQL-Statements wurden erfolgreich in $file gespeichert!🔥🚀\n";
    }

    public static function getDatabaseName(bool $isTestMode = false): string
    {
        $datenbankConfig = include(dirname(__DIR__) . '/datenbank/Config.php');
        return $isTestMode ? $datenbankConfig['dbtestname'] : $datenbankConfig['dbname'];
    }
}