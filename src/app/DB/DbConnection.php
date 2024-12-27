<?php

declare(strict_types=1);

namespace App\DB;

final class DbConnection
{
    private static string $host = 'postgres';
    private static int $port = 5432;
    private static string $dbName = 'developer';
    private static string $user = 'developer';
    private static string $password = 'secret';
    private static array $options = [];

    private static ?\PDO $dbInstance = null;

    public static function getInstance(): ?\PDO
    {
        if (self::$dbInstance == null) {
            $dsn = "pgsql:host=" . self::$host . ";port=" . self::$port . ";dbname=" . self::$dbName;

            try {
                self::$dbInstance = new \PDO($dsn, self::$user, self::$password, self::$options);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        return self::$dbInstance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}