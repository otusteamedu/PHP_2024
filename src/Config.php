<?php

namespace AKornienko\Php2024;

readonly class Config
{
    public string $host;
    public string $port;
    public string $dbname;
    public string $dbUser;
    public string $password;

    public function __construct()
    {
        $this->host = getenv("MYSQL_HOST");
        $this->port = getenv("MYSQL_PORT");
        $this->dbname = getenv("MYSQL_DATABASE");
        $this->dbUser = getenv("MYSQL_USER");
        $this->password = getenv("MYSQL_PASSWORD");
    }
}
