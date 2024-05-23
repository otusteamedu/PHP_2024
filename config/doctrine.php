<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__ . '/../src/Domain/Entity']
);

$connectionParams = [
    'driver' => 'pdo_mysql',
    'host' => getenv('MYSQL_CONTAINER_NAME'),
    'user' => getenv('MYSQL_USER'),
    'password' => getenv('MYSQL_PASSWORD'),
    'dbname' => getenv('MYSQL_DATABASE'),
];;
$conn = DriverManager::getConnection($connectionParams, $config);
$entityManager = new EntityManager($conn, $config);

return $entityManager;
