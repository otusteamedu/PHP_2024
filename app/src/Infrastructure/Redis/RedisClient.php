<?php

declare(strict_types=1);

namespace Aware\App\Infrastructure\Redis;

use Aware\App\Domain\Event\Event;
use Redis;

class RedisClient
{
    private Redis $client;

    public function __construct()
    {
        $this->connect();
    }

    public function connect(): void
    {
        $this->client = new Redis();
        $this->client->connect($_ENV['REDIS_HOST'], (int) $_ENV['REDIS_PORT']);

        try {
            $this->client->ping();
        } catch (\Exception $e) {
            die("Redis connection failed: " . $e->getMessage());
        }
    }

    public function zAdd($key, $score, $value): void
    {
        $this->client->zAdd($key, $score, $value);
    }

    public function zRevRange($key, $from, $to): false|array|Redis
    {
        return $this->client->zRevRange($key, $from, $to);
    }

    public function deleteAll(): void
    {
        $this->client->flushAll();
    }

    public function getAllEvents(): array
    {
        $keys = $this->client->keys('*:*');
        $allEvents = [];
        $processedEvents = []; // Для отслеживания уже добавленных событий

        foreach ($keys as $key) {
            $events = $this->zRevRange($key, 0, -1);
            foreach ($events as $eventJson) {
                // Проверка на дубликаты, так как одно событие может быть в нескольких наборах
                if (!in_array($eventJson, $processedEvents)) {
                    $event = Event::decode($eventJson);
                    $allEvents[] = $event;
                    $processedEvents[] = $eventJson;
                }
            }
        }

        return $allEvents;
    }
}
