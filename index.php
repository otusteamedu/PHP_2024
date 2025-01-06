<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Amikha1lov\DataMapper\DatabaseConnection;
use Amikha1lov\DataMapper\Mappers\ProductMapper;
use Amikha1lov\DataMapper\Mappers\UserMapper;

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

    $userMapper = new UserMapper($databaseConnection);
    $productMapper = new ProductMapper($databaseConnection);

    dump($userMapper->findById(1));
    dump($userMapper->findById(2));
    dump($productMapper->findById(2));
    dump($userMapper->findById(3));
    dump($userMapper->findAll());
    dump($productMapper->findAll());

} catch (\PDOException $exception) {
    echo $exception->getMessage();
}
