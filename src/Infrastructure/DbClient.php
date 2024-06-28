<?php

namespace App\Infrastructure;

use PDO;

class DbClient
{
    private PDO $dbConnection;

    public function __construct(Config $config)
    {
        $this->dbConnection = new PDO(
            "mysql:host=$config->mysqlHost;port=$config->mysqlPort;dbname=$config->mysqlDbname",
            $config->mysqlDbUser,
            $config->mysqlPassword
        );
    }

    public function getDbConnection(): PDO
    {
        return $this->dbConnection;
    }
}
