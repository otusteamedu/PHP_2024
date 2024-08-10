<?php

namespace App\Connections;

use App\Core\Config;
use Exception;
use PDO;

class DatabaseConnection
{
    protected PDO $pdo;

    /**
     * @throws Exception
     */
    public function getConnection(): PDO
    {
        if (!isset($this->pdo)) {
            $this->connect();
        }

        return $this->pdo;
    }

    /**
     * @throws Exception
     */
    protected function connect(): void
    {
        $connection = Config::get('db', 'default');

        if (!$connection) {
            throw new Exception('Default connection is not set.');
        }

        $config = Config::get('db', $connection);

        if (!$config) {
            throw new Exception("Connection $connection does not have any configuration.");
        }

        $dsn = "$connection:host={$config['host']};port={$config['port']};dbname={$config['db']};charset={$config['charset']}";

        $this->pdo = new PDO($dsn, $config['user'], $config['password']);
    }
}
