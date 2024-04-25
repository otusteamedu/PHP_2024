<?php

namespace AKornienko\Php2024;

use PDO;

class DbClient
{
    private PDO $dbConnection;

    public function __construct(Config $config)
    {
        $this->dbConnection = new PDO(
            "mysql:host=$config->host;port=$config->port;dbname=$config->dbname",
            $config->dbUser,
            $config->password
        );
    }

    public function getDbConnection(): PDO
    {
        return $this->dbConnection;
    }
}
