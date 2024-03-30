<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Infrastructure\Repository\Redis;

use RedisException;
use Rmulyukov\Hw\Application\Event\Event;
use Rmulyukov\Hw\Application\Repository\EventCommandRepositoryInterface;

final readonly class RedisEventCommandRepository extends AbstractRedisRepository implements EventCommandRepositoryInterface
{
    /**
     * @throws RedisException
     */
    public function add(Event $event): bool
    {
        $this->client->connect($this->host, $this->port);

        foreach ($event->getCriteria() as $criteria) {
            $this->client->zAdd("{$criteria->getName()}:{$criteria->getValue()}", $event->getPriority(), $event->getId());
        }
        $this->client->hMSet('event:' . $event->getId(), $this->prepareCriteria($event));

        $this->client->close();

        return true;
    }

    /**
     * @throws RedisException
     */
    public function clear(): bool
    {
        $this->client->connect($this->host, $this->port);
        $result = $this->client->flushAll();
        $this->client->close();

        return (bool) $result;
    }

    private function prepareCriteria(Event $event): array
    {
        $criterias = [];
        foreach ($event->getCriteria() as $criteria) {
            $criterias[$criteria->getName()] = $criteria->getValue();
        }

        return $criterias;
    }
}
