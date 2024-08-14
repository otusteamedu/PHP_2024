<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Db;

use PDO;
use Viking311\DbPattern\Config\Config;

class PdoFactory
{
    private static ?PDO $pdo = null;

    public static function getPdo(): PDO
    {
        if (is_null(self::$pdo)) {
            $config = new Config();

            $dsn = sprintf(
                'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s',
                $config->host,
                $config->port,
                $config->dbName,
                $config->user,
                $config->password,
            );

            self::$pdo = new PDO($dsn);
        }

        return self::$pdo;
    }
}
