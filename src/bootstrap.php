<?php

namespace Skudashkin\Hw16;
// bootstrap.php
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$test = "Hello world";

// Create a simple "default" Doctrine ORM configuration for Attributes
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/'],
    isDevMode: true,
);

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