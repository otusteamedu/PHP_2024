<?php

declare(strict_types=1);

namespace Evgenyart\Hw13;

use Exception;
use PDO;

class DBConnection
{
    private $dsn;

    public function __construct()
    {
        $config = Config::load();

        $this->dsn = sprintf(
            'pgsql:host=%s;dbname=%s;user=%s;password=%s',
            $config['host'],
            $config['db'],
            $config['user'],
            $config['password']
        );
    }

    public function connect()
    {
        return new PDO($this->dsn);
    }
}
