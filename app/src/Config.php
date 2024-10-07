<?php

declare(strict_types=1);

namespace Evgenyart\Hw13;

use Exception;

class Config
{
    public static function load()
    {
        $host = getenv('POSTGRES_HOST');
        $db = getenv('POSTGRES_DB');
        $user = getenv('POSTGRES_USER');
        $password = getenv('POSTGRES_PASSWORD');

        if (!$host) {
            throw new Exception("No isset POSTGRES_HOST in .env");
        }

        if (!$db) {
            throw new Exception("No isset POSTGRES_DB in .env");
        }

        if (!$user) {
            throw new Exception("No isset POSTGRES_USER in .env");
        }

        if (!$password) {
            throw new Exception("No isset POSTGRES_PASSWORD in .env");
        }

        return [
            'host' => $host,
            'db' => $db,
            'user' => $user,
            'password' => $password
        ];
    }
}
