<?php

namespace App\Infrastructure;

class Config
{
    public string $mysqlHost;
    public string $mysqlPort;
    public string $mysqlDbname;
    public string $mysqlDbUser;
    public string $mysqlPassword;
    public string $rabbitHost;
    public string $rabbitPort;
    public string $rabbitUser;
    public string $rabbitPassword;

    public function __construct()
    {
        $this->mysqlHost = getenv("MYSQL_HOST");
        $this->mysqlPort = getenv("MYSQL_PORT");
        $this->mysqlDbname = getenv("MYSQL_DATABASE");
        $this->mysqlDbUser = getenv("MYSQL_USER");
        $this->mysqlPassword = getenv("MYSQL_PASSWORD");
        $this->rabbitHost = getenv("RABBIT_HOST");
        $this->rabbitPort = getenv("RABBIT_PORT");
        $this->rabbitUser = getenv("RABBIT_USER");
        $this->rabbitPassword = getenv("RABBIT_PASSWORD");
    }
}