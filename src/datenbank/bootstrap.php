<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [dirname(__DIR__, 2) . '/src/datenbank/Entitaeten'],
    isDevMode: true,
);

$dsnParser = new DsnParser();
$connectionParams = $dsnParser
    ->parse('mysqli://root:@localhost/fastfood');

$connection = DriverManager::getConnection($connectionParams, $config);

$entityManager = new EntityManager($connection, $config);