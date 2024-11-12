<?php

namespace App;

class MySQLConnection
{
    private $host;
    private $username;
    private $password;
    private $dbname;
    private $connection;

    public function __construct($host, $username, $password, $dbname)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
    }

    public function connect()
    {
        try {
            // Create a new PDO instance and set the connection parameters
            $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
            $this->connection = new \PDO($dsn, $this->username, $this->password);

            // Set the PDO error mode to exception
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}