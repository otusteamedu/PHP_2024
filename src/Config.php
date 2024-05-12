<?php

declare(strict_types=1);

namespace AShutov\Hw17;

readonly class Config
{
    public string $db;
    public string $user;
    public string $host;
    public string $pass;
    public string $dsn;

    public function __construct()
    {
        $this->db = $_ENV["MYSQL_DATABASE"];
        $this->user = $_ENV["MYSQL_ROOT_USER"];
        $this->host = $_ENV["MYSQL_HOST"];
        $this->pass = $_ENV["MYSQL_PASSWORD"];
        $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=utf8";
    }
}
