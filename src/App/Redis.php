<?php

declare(strict_types=1);

namespace App;

use Predis\Client;

class Redis
{
    private static ?Client $client = null;

    public static function getInstance()
    {
        if (is_null(self::$client)) {
            self::$client = new Client(
                [
                    ["host" => "otus-redis-1", "port" => 6381],
                    ["host" => "otus-redis-2", "port" => 6382],
                    ["host" => "otus-redis-3", "port" => 6383],
                    ["host" => "otus-redis-4", "port" => 6384],
                    ["host" => "otus-redis-5", "port" => 6385],
                    ["host" => "otus-redis-6", "port" => 6386]
                ],
                ['cluster' => 'redis']
            );
        }

        return self::$client;
    }

    public static function get(string $key)
    {
        return self::getInstance()->get($key);
    }

    public static function set(string $key, $value)
    {
        return self::getInstance()->set($key, $value);
    }
}
