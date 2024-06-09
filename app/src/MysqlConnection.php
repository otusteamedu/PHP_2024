<?php

namespace Dsergei\Hw5;

class MysqlConnection
{
    private static $instanse = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): \PDO
    {
        if (self::$instanse === null) {
            self::$instanse = new \PDO(
                getenv('MYSQL_DSN'),
                getenv('MYSQL_USER'),
                getenv('MYSQL_PASSWORD'),
            );
        }

        return self::$instanse;
    }
}
