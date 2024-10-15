<?php

declare(strict_types=1);

namespace Irayu\Hw13\Infrastructure\Repository\Mysql;

use PDO;

class ClientFactory
{
    public static function create(
        string $host,
        int $port,
        string $user,
        string $password,
        string $dbName,
    ): PDO {
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host:$port;dbname=$dbName;charset=$charset";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new PDO($dsn, $user, $password, $options);
    }
}
