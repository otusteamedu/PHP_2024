<?php

declare(strict_types=1);

namespace Afilipov\Hw13;

use PDO;

readonly class DbConnection
{
    public PDO $pdo;

    public function __construct()
    {
        $dsn = sprintf("mysql:host=%s;dbname=%s", getenv('MYSQL_CONTAINER_NAME'), getenv('MYSQL_DATABASE'));
        $this->pdo = new PDO(
            $dsn,
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD')
        );
    }
}
