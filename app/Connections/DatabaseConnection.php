<?php

namespace App\Connections;

use App\Core\Config;
use PDO;

class DatabaseConnection
{
    private PDO $pdo;

    public function getConnection(): PDO
    {
        if (!isset($this->pdo)) {
            $this->connect();
        }

        return $this->pdo;
    }

    private function connect(): void
    {
        $config = Config::get('db', 'credentials');

        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['db']};charset={$config['charset']}";

        $this->pdo = new PDO($dsn, $config['user'], $config['password']);
    }
}