<?php

declare(strict_types=1);

namespace App\Shared\Database;

use PDO;

class PDOFactory
{
    public function make(): PDO
    {
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s;user=%s;password=%s;',
            getenv('POSTGRESQL_HOST'),
            getenv('POSTGRESQL_PORT'),
            getenv('POSTGRESQL_DB'),
            getenv('POSTGRESQL_USER'),
            getenv('POSTGRESQL_PASSWORD'),
        );

        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => true,
        ];

        return new PDO($dsn, null, null, $options);
    }
}
