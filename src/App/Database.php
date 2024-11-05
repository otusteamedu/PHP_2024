<?php

namespace Komarov\Hw14\App;

use Komarov\Hw14\Exception\AppException;
use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO("pgsql:host=localhost;dbname=db", "username", "password");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                throw new AppException("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$connection;
    }
}
