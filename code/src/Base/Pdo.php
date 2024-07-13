<?php

namespace src\Base;

use PDOException;

class Pdo
{
    protected string $host;
    protected string $baseName;
    protected string $user;
    protected string $password;

    public function __construct($host, $baseName, $user, $password)
    {
        $this->host = $host;
        $this->baseName = $baseName;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @throws \Exception
     */
    public function connect()
    {
        try {
            $pdo = new \PDO("mysql:host={$this->host};dbname={$this->baseName}", $this->user, $this->password);
        } catch (PDOException $e) {
            throw new \Exception('Pdo error');
        }

        return $pdo;
    }
}
