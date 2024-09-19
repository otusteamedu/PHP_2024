<?php

declare(strict_types=1);

namespace Otus\AppPDO;

use PDO;

class Entry
{
    private $pdo;

    public function __construct()
    {
        $config = (new Config())->getDatabaseConfig();

        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            $config['host'],
            $config['port'],
            $config['db']
        );

        $this->pdo = new PDO($dsn, $config['user'], $config['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
