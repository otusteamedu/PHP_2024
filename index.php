<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Amikha1lov\DataMapper\DatabaseConnection;
use Amikha1lov\DataMapper\DataMapper;
use Amikha1lov\DataMapper\Entities\Product;
use Amikha1lov\DataMapper\Entities\User;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $dsn = sprintf(
        '%s:host=%s;port=%d;dbname=%s',
        $_ENV['DB_CONNECTION'],
        $_ENV['DB_HOST'],
        $_ENV['DB_PORT'],
        $_ENV['DB_DATABASE']
    );

    $databaseConnection = new DatabaseConnection(
        $dsn,
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD']
    );

    $mapper = new DataMapper($databaseConnection);

    $userEntity = $mapper->findById(User::class, 1);
    $productEntity = $mapper->findById(Product::class, 1);

    $userCollection = $mapper->findAll(User::class);
    $productCollection = $mapper->findAll(Product::class);

    dump($userEntity);
    dump($userCollection);
    dump($productEntity);
    dump($productCollection);
} catch (\PDOException $exception) {
    echo $exception->getMessage();
}
