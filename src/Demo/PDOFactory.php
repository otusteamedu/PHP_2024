<?php

declare(strict_types=1);

namespace AlexanderGladkov\Demo;

use PDO;

class PDOFactory
{
    public function create(
        string $host,
        string $port,
        string $dbName,
        string $user,
        string $password
    ): PDO {
        $dns = "pgsql:host=$host;port=$port;dbname=$dbName;user=$user;password=$password;";
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => true,
        ];

        return new PDO($dns, null, null, $options);
    }
}
