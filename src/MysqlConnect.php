<?php

namespace Ahar\Hw13;

use PDO;

class MysqlConnect
{
    public PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            sprintf("mysql:host=%s;dbname=%s", getenv('MYSQL_HOST'), getenv('MYSQL_DATABASE')),
            getenv('MYSQL_USER'),
            getenv('MYSQL_PASSWORD')
        );
    }
}
