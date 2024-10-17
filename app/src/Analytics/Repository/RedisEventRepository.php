<?php

declare(strict_types=1);

namespace App\Analytics\Repository;

use App\Analytics\Exception\CouldNotDeleteEventException;
use App\Analytics\Exception\CouldNotSaveEventException;
use App\Analytics\Factory\EventFactory;
use App\Analytics\Model\Event;
use App\Analytics\Model\EventCondition;
use Exception;
use Generator;
use Redis;

final readonly class RedisEventRepository implements EventRepositoryInterface
{
    private const KEY = 'events';

    private Redis $client;
    private EventFactory $eventFactory;

    public function __construct()
    {
        $options = [
            'host' => getenv('REDIS_HOST'),
            'port' => (int) getenv('REDIS_PORT'),
            'auth' => [
                getenv('REDIS_USER'),
                getenv('REDIS_USER_PASSWORD'),
            ],
        ];

        $this->client = new Redis($options);
        $this->eventFactory = new EventFactory();
    }

    public function save(Event $event): void
    {
        try {
            $this->client->zAdd(self::KEY, $event->priority, $event->toJson());
        } catch (Exception) {
            throw CouldNotSaveEventException::make();
        }
    }

    public function findByConditions(EventCondition ...$conditions): ?Event
    {
        /** @var Event $event */
        foreach ($this->iterate() as $event) {
            if ($event->matches(...$conditions)) {
                return $event;
            }
        }

        return null;
    }

    public function clear(): void
    {
        try {
            $this->client->del(self::KEY);
        } catch (Exception) {
            throw CouldNotDeleteEventException::make();
        }
    }

    private function iterate(): Generator
    {
        $position = 0;

        while ($position < $this->client->zCard(self::KEY)) {
            $options = [
                'LIMIT' => [$position++, 1],
                'WITHSCORES' => true
            ];

            $rawEvent = $this->client->zRevRangeByScore(self::KEY, '+inf', '-inf', $options);

            $data = json_decode(key($rawEvent), true);
            $data['priority'] = current($rawEvent);

            yield $this->eventFactory->makeFromArray($data);
        }
    }
}
