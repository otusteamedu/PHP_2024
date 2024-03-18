<?php

declare(strict_types=1);

if (! function_exists('isMySQLConnected')) {
    function isMySQLConnected(): bool
    {
        $dsn = sprintf(
            "mysql:host=%s;port=%s;dbname=%s",
            getenv('MYSQL_HOST'),
            getenv('MYSQL_PORT'),
            getenv('MYSQL_DATABASE')
        );

        try {
            new PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
        } catch (Throwable $e) {
            return false;
        }

        return true;
    }
}
