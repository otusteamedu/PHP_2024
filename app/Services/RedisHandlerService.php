<?php

namespace App\Services;

use App\Interfaces\EventHandlerInterface;
use App\Models\Event;
use Generator;
use JsonException;
use Redis;
use RedisException;

/**
 * Redis storage handler.
 */
class RedisHandlerService implements EventHandlerInterface
{
    /**
     * @var Redis Redis driver.
     */
    protected Redis $redis;

    /**
     * Creates a new instance of redis driver.
     */
    public function __construct()
    {
        $this->redis = new Redis([
            'host' => getenv('REDIS_HOST'),
            'port' => (int)getenv('REDIS_PORT')
        ]);
    }

    /**
     * @inheritdoc
     * @throws RedisException
     * @throws JsonException
     */
    public function add(array $fields): Event
    {
//        $this->redis->flushAll();

        // Вытаскиваем/инициализируем последний ID ивента.
        $lastEventId = $this->redis->incr('events:last_event_id');

        // Добавляем ID чтобы прикрепить ее к модели.
        $fields['id'] = $lastEventId;

        // Создаем модель.
        $event = Event::instance($fields);

        // Добавляем сам ивент.
        $this->redis->hMSet("events:$lastEventId", [
            'id' => $event->id,
            'priority' => $event->priority,
            'conditions' => json_encode($event->conditions),
            'event' => $event->event
        ]);

        // Добавляем в коллекцию по приоритетам.
        $this->redis->zAdd('events:priority_index', $event->priority, $lastEventId);

        // Добавляем в коллекцию по условиям.
        foreach ($event->conditions as $key => $value) {
            $this->redis->sAdd("events:condition_index:$key:$value", $lastEventId);
        }

        return $event;
    }

    /**
     * @inheritdoc
     *
     * @throws RedisException If Redis fails.
     * @throws JsonException If Json fails.
     */
    public function find(array $conditions = []): Generator
    {
        $start = 0;

        // Ищем пока есть что искать.
        while ($eventIds = $this->redis->zRange('events:priority_index', $start, $start + 10)) {
            foreach ($eventIds as $eventId) {
                $match = true;

                // Проверяем если есть такой ивент в нашей колекции с условиям.
                foreach ($conditions as $key => $value) {
                    if (!$this->redis->sIsMember("events:condition_index:$key:$value", $eventId)) {
                        $match = false;

                        break;
                    }
                }

                // Если ок, то возвращаем.
                if ($match) {
                    yield new Event(...$this->redis->hGetAll("events:$eventId"));
                }
            }

            $start += 10;
        }
    }

    /**
     * @inheritdoc
     * @throws RedisException
     */
    public function flush(): bool
    {
        return $this->redis->flushAll();
    }
}
