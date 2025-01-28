<?php
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src'],
    isDevMode: true,
);
// or if you prefer XML
// $config = ORMSetup::createXMLMetadataConfiguration(
//    paths: [__DIR__ . '/config/xml'],
//    isDevMode: true,
//);

// configuring the database connection
//$connection = DriverManager::getConnection([
//     'driver' => 'pdo_sqlite',
//     'path' => __DIR__ . '/db.sqlite',
// ], $config);
//$connection = DriverManager::getConnection([
//    'driver' => 'pdo_sqlite',
//    'path' => __DIR__ . '/db.sqlite',
//], $config);


// configuring the database connection
$connectionParams = array(
    'dbname' => 'otus',
    'user' => 'otus',
    'password' => 'otus',
    'host' => 'localhost',
    'port' => 33060,
    'driver' => 'pdo_mysql',
);
$connection = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);


// obtaining the entity manager
$entityManager = new EntityManager($connection, $config);