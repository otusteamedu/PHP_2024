<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw14\Infrastructure\Database\Postgesql;

use PDO;
use PDOException;

class DbConnection
{
    private string $host = "db";
    private string $port = "5432";
    private string $dbname = "postgres";
    private string $username = "root";
    private string $password = "12345678";

    public function getConnection(): PDO
    {
        try {
            $connection = new PDO("pgsql:host=$this->host;port=$this->port;dbname=$this->dbname;user=$this->username;password=$this->password");
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }
        return $connection;
    }
}