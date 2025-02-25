<?php

declare(strict_types=1);

namespace Infrastructure\Database;

use PDO;

final class DatabaseConnection
{
    private static ?self $instance = null;
    private PDO $connection;

    final public function __construct(
        private readonly string $host = 'postgres',
        private readonly int    $port = 5432,
        private readonly string $dbName = 'developer',
        private readonly string $user = 'developer',
        private readonly string $password = 'secret',
        private readonly array  $options = [],
    )
    {
        $dsn = 'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbName;

        $this->connection = new PDO($dsn, $this->user, $this->password, $this->options);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
