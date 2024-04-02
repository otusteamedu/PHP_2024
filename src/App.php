<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Dotenv\Dotenv;
use Exception;
use Redis;

final class App
{
    public function run(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

// redis data
        $redisHost = $_ENV['REDIS_HOST'] ?? null;
        $redisPort = $_ENV['REDIS_PORT'] ?? null;

// redis connection check
        try {
            $redis = new Redis();
            $redis->connect($redisHost, (int)$redisPort);
            echo "Соединение с Redis успешно установлено." . PHP_EOL;
        } catch (Exception $e) {
            echo "Ошибка подключения к Redis: " . $e->getMessage();
        }
    }
}
