<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Event;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\EventRepositoryInterface;

readonly class RedisEventRepository implements EventRepositoryInterface
{
    private \Redis $client;
    public function __construct()
    {
        $this->client = new \Redis();
        if (!$this->client->connect($_ENV['REDIS_HOST'], (int) $_ENV['REDIS_PORT'])) {
            throw new DomainException('Could not connect to redis server');
        }
    }

    public function save(Event $event): void
    {
        $condition = $event->getCondition();
        ksort($condition);
        $saveData = [
            'event' => $event->getEvent(),
            'condition' => $condition,
        ];
        if (!$this->client->zAdd('events', $event->getPriority(), json_encode($saveData))) {
            throw new DomainException('Could not save event');
        }
    }

    public function deleteAll(): void
    {
        if (!$this->client->del('events')) {
            throw new DomainException('Could not delete events');
        }
    }

    /**
     * @throws NotFoundException
     * @throws \RedisException
     */
    public function matchByCondition(array $condition): ?Event
    {
        $startIndex = 0;
        $limit = 5_000;
        $compareCondition = $condition;

        ksort($compareCondition);
        $compareString = '';
        foreach ($compareCondition as $key => $value) {
            $compareString .= "{$key}:{$value};";
        }

        $selectOptions = ['WITHSCORES' => true, 'REV'];
        while (
            $results = $this->client->zRange('events', $startIndex, $startIndex + ($limit - 1), $selectOptions)
        ) {
            foreach ($results as $value => $score) {
                $item = json_decode($value, true);
                $resultString = '';
                foreach ($item['condition'] as $key => $value) {
                    $resultString .= "{$key}:{$value};";
                }

                if ((mb_strpos($resultString, $compareString) !== false)
                    || (mb_strpos($compareString, $resultString) !== false)
                ) {
                    return new Event((string) $item['event'], (int) $score, (array) $item['condition']);
                }
            }
            $startIndex += $limit;
        }

        throw new NotFoundException('Could not match events');
    }
}