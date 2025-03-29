<?php

namespace App;

use Predis\Client;

class EventManager
{
    private $redis;

    public function __construct(Client $redis)
    {
        $this->redis = $redis;
    }

    // Добавление события
    public function addEvent(string $id, int $priority, array $conditions, array $event): void
    {
        // Сохраняем событие как хэш
        $this->redis->hMSet("event:$id", [
            'priority' => $priority,
            'conditions' => json_encode($conditions),
            'event' => json_encode($event),
        ]);

        // Индексируем условия
        foreach ($conditions as $param => $value) {
            $this->redis->sAdd("condition:$param:$value", $id);
        }
    }

    // Очистка всех событий
    public function clearEvents(): void
    {
        // Удаляем все события
        $keys = $this->redis->keys('event:*');
        if (!empty($keys)) {
            $this->redis->del($keys);
        }

        // Удаляем все индексы условий
        $conditionKeys = $this->redis->keys('condition:*');
        if (!empty($conditionKeys)) {
            $this->redis->del($conditionKeys);
        }
    }

    // Поиск наиболее подходящего события
    public function getBestEvent(array $params): array
    {
        $matchingEventIds = null;

        // Находим события, соответствующие каждому условию
        foreach ($params as $param => $value) {
            $key = "condition:$param:$value";
            $ids = $this->redis->sMembers($key);

            if ($matchingEventIds === null) {
                $matchingEventIds = $ids;
            } else {
                $matchingEventIds = array_intersect($matchingEventIds, $ids);
            }

            // Если нет совпадений, выходим
            if (empty($matchingEventIds)) {
                return ['status' => 'error', 'message' => 'No matching events found.'];
            }
        }

        // Получаем данные событий и сортируем по приоритету
        $events = [];
        foreach ($matchingEventIds as $id) {
            $eventData = $this->redis->hGetAll("event:$id");
            $events[] = [
                'id' => $id,
                'priority' => (int)$eventData['priority'],
                'event' => json_decode($eventData['event'], true),
            ];
        }

        // Сортируем события по убыванию приоритета
        usort($events, function ($a, $b) {
            return $b['priority'] - $a['priority'];
        });

        // Возвращаем событие с наивысшим приоритетом
        if (!empty($events)) {
            return ['status' => 'success', 'event' => $events[0]['event']];
        }

        return ['status' => 'error', 'message' => 'No matching events found.'];
    }
}