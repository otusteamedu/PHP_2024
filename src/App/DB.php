<?php

namespace App;

use PDO;

class DB
{
    private static ?PDO $connection = null;

    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        $env = App::env();

        if (is_null(self::$connection)) {
            self::$connection = new PDO("mysql:host={$env['MYSQL_HOST']};dbname={$env['MYSQL_DATABASE']};charset=utf8mb4", $env['MYSQL_USER'], $env['MYSQL_PASSWORD']);
        }

        return self::$connection;
    }
}