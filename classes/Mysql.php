<?php

namespace classes;

use PDO;
use PDOException;

class Mysql
{
    private const DEFAULT_HOST = '127.0.0.1';
    private const DEFAULT_DBNAME = 'test';
    private const DEFAULT_PORT = 3306;

    /**
     * @param string $host
     * @param int $port
     */
    public function __construct(
        private string $user,
        private string $pass,
        private string $host = self::DEFAULT_HOST,
        private string $dbname = self::DEFAULT_DBNAME,
        private int $port = self::DEFAULT_PORT
    ) {
    }

    /**
     * @return string
     */
    public function ping()
    {
        try {
            $DBH = new PDO("mysql:host=$this->host;dbname=$this->dbname;port=$this->port", $this->user, $this->pass);
            $DBH->query('SELECT 1');
            return "established";
        } catch (PDOException $e) {
            return "error " . $e->getMessage();
        }
    }
}
