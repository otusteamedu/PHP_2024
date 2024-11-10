<?php

namespace Database;

class DatabaseConnection {
    private $host;
    private $name;
    private $user;
    private $pass;
    private $port;
    private $pdo;

    public function __construct($config)
    {
        $this->host = $config["host"];
        $this->name = $config["name"];
        $this->user = $config["user"];
        $this->pass = $config["pass"];
        $this->port = $config["port"];
    }

    public function connect()
    {
        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->name};user={$this->user};password={$this->pass}";
            $pdo = new \PDO($dsn);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            echo "Successful connection to PostgreSQL" . "<br>";
            return $this->pdo;
        } catch(\PDOException $e) {
            echo "Connection error: " . $e->getMessage() . "<br>";
            return null;
        }
    }
}
