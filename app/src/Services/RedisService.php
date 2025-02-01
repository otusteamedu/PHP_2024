<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusWebserversApp\Services;

use RedisException;
use Dotenv\Dotenv;
use Redis;

class RedisService
{
    /** @var ?RedisService */
    private static ?RedisService $instance = null;

    /** @var Redis */
    public Redis $redis;

    /** @var string */
    public string $path;

    /** @var string */
    public string $host;

    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        $this->host = $_ENV['REDIS_HOST'];
        $this->path = 'tcp://' . $_ENV['REDIS_HOST'] . ':' . $_ENV['REDIS_PORT'];

        try {
            $this->redis = new Redis();
            $this->redis->connect($_ENV['REDIS_HOST'], (int)$_ENV['REDIS_PORT']);
        } catch (RedisException $e) {
            exit('Redis connect error: ' . $e->getMessage());
        }
    }

    /**
     * Метод проверяет был ли создан уже
     * объект или нет
     *
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
