<?php

namespace AnatolyShilyaev\Backend\Infrastructure\Config;

final class Connection
{
    private static ?Connection $conn = null;

    public function connect()
    {
        // чтение параметров в файле конфигурации ini
        $params = parse_ini_file('database.ini');
        if ($params === false) {
            throw new \Exception("Error reading database configuration file");
        }

        // подключение к базе данных postgresql
        $conStr = sprintf(
            "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s",
            $params['host'],
            $params['port'],
            $params['database'],
            $params['user'],
            $params['password']
        );

        $pdo = new \PDO($conStr);

        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function get()
    {
        if (null === static::$conn) {
            static::$conn = new self();
        }

        return static::$conn;
    }

    protected function __construct()
    {
        // Empty constructor
    }
}
