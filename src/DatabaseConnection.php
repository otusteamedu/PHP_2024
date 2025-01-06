<?php

declare(strict_types=1);

namespace Amikha1lov\DataMapper;

use PDO;

class DatabaseConnection
{
    private PDO $connection;

    public function __construct(string $dsn, string $username = '', string $password = '')
    {
        $this->connection = new PDO($dsn, $username, $password);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
