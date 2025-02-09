<?php

namespace KRudenko\Otus\Database;

use PDO;

class Connection
{
    private static ?PDO $pdo = null;

    public static function connect(): PDO
    {
        self::$pdo = new PDO(
            $_ENV['DATABASE_DSN'],
            $_ENV['DATABASE_USER'],
            $_ENV['DATABASE_PASSWORD'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        return self::$pdo;
    }

    public static function get(): PDO
    {
        if (self::$pdo === null) {
            self::connect();
        }

        return self::$pdo;
    }
}
