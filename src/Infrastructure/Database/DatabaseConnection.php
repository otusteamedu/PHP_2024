<?php

declare(strict_types=1);

namespace Infrastructure\Database;

use PDO;

final class DatabaseConnection
{
    private static ?self $instance = null;
    private PDO $connection;

    private static string $host = 'postgres';
    private static int $port = 5432;
    private static string $dbName = 'developer';
    private static string $user = 'developer';
    private static string $password = 'secret';
    private static array $options = [];

    private function __construct()
    {
        $dsn = 'pgsql:host=' . self::$host . ';port=' . self::$port . ';dbname=' . self::$dbName;

        $this->connection = new PDO($dsn, self::$user, self::$password, self::$options);
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
