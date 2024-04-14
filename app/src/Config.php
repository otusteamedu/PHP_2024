<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis;

class Config
{
    public const REDIS_HOST = 'redis_host';
    public const REDIS_PORT = 'redis_port';
    public const PARAMETER_NAMES = 'parameters';
    public const EVENTS_COUNT = 'events_count';

    private array $data;

    /**
     * throws \RuntimeException
     */
    public function __construct()
    {
        $data = parse_ini_file(dirname(__DIR__) . '/config.ini');

        if (false === $data) {
            throw new \RuntimeException('Unable to parse config.ini');
        }

        $this->data = $data;
    }

    public function getRedisHost(): string
    {
        return $this->data[self::REDIS_HOST];
    }

    public function getRedisPort(): int
    {
        return (int) $this->data[self::REDIS_PORT];
    }

    public function getParameterNames(): array
    {
        return $this->data[self::PARAMETER_NAMES];
    }

    public function getEventsCount(): int
    {
        return (int) $this->data[self::EVENTS_COUNT];
    }
}
