<?php

declare(strict_types=1);

namespace AnatolyShilyaev\Hw11\Storage;

use AnatolyShilyaev\Hw11\Storage\StorageInterface;
use AnatolyShilyaev\Hw11\Client;

class RedisHelper implements StorageInterface
{
    private $client;

    public function __construct()
    {
        $this->client = (new Client())->client;
    }

    // Добавление события
    public function add(string $event, int $priority, string $conditions): void
    {
        $eventId = uniqid('event_', true);
        $this->client->zAdd('events', $priority, $eventId);

        // Сохраняем данные события
        $this->client->hset("$eventId", 'event', $event);
        $this->client->hset("$eventId", 'conditions', $conditions);
    }

    // Очистка всех событий
    public function clear(): void
    {
        $eventIds = $this->client->zrange('events', 0, -1);
        foreach ($eventIds as $eventId) {
            $this->client->del("$eventId");
        }
        $this->client->del('events');
    }

    // Обработка пользовательского запроса
    public function findBestMatch(array $params): ?string
    {
        // Получаем все события, отсортированные по убыванию приоритета
        $eventIds = $this->client->zrevrange('events', 0, -1);
        foreach ($eventIds as $eventId) {
            //Получаем невалидную JSON-alike строку
            $invalidJson = $this->client->hget("$eventId", 'conditions');

            // Преобразуем в валидный JSON
            $validJson = preg_replace('/(\w+)\s*=\s*/', '"$1": ', $invalidJson);

            // Декодируем в Ассоциативный массив
            $conditions = json_decode($validJson, true);

            //Получаем строку
            $event = $this->client->hget("$eventId", 'event');

            // Проверяем выполнение условий
            if ($this->conditionsMet($conditions, $params)) {
                return $event; // Возвращаем первое подходящее событие
            }
        }

        return null; // Ничего не найдено
    }

    // Получение всех событий
    public function get(string $key): array
    {
        return $this->client->zrange($key, 0, -1, ['WITHSCORES' => true]);
    }

    // Проверка выполнения условий
    private function conditionsMet(array $conditions, array $params): bool
    {
        foreach ($conditions as $key => $value) {
            if (!isset($params[$key]) || $params[$key] != $value) {
                return false;
            }
        }
        return true;
    }
}
