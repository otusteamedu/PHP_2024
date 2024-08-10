<?php

namespace App\Mappers;

use App\Connections\DatabaseConnection;
use Exception;
use PDO;

class AbstractMapper
{
    protected static PDO $pdo;

    /**
     * @throws Exception
     */
    public static function initialize(DatabaseConnection $db): void
    {
        static::$pdo = $db->getConnection();
    }
}
