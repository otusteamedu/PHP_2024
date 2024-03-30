<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Infrastructure\Repository\Redis;

use RedisException;
use Rmulyukov\Hw\Application\Event\Criteria;
use Rmulyukov\Hw\Application\Event\Event;
use Rmulyukov\Hw\Application\Factory\EventFactory;
use Rmulyukov\Hw\Application\Repository\EventQueryRepositoryInterface;

use function array_map;

final readonly class RedisEventQueryRepository extends AbstractRedisRepository implements EventQueryRepositoryInterface
{
    public function __construct(
        private EventFactory $factory,
        string $host,
        int $port
    ) {
        parent::__construct($host, $port);
    }

    /**
     * @throws RedisException
     */
    public function getByCriteria(Criteria $criteria, Criteria ...$criterias): Event
    {
        $this->client->connect($this->host, $this->port);

        $event = $this->findEvent($criteria, ...$criterias);
        $this->removeEvent($event);

        $this->client->close();

        return $event;
    }

    /**
     * @throws RedisException
     */
    private function findEvent(Criteria $criteria, Criteria ...$criterias): Event
    {
        $sets = $this->getCriteriaSets($criteria, ...$criterias);
        $this->client->zInterStore('query', $sets, null, 'max');
        $event = $this->client->zPopMax('query');
        $range = $this->client->zRange('query', 0, -1);
        if (!empty($range)) {
            $this->client->zRem('query', ...$this->client->zRange('query', 0, -1));
        }

        $eventKey = array_key_first($event);
        $params = $this->client->hGetAll("event:$eventKey");

        return  $this->factory->create((int) $eventKey, (int) $event[$eventKey], $params);
    }

    /**
     * @throws RedisException
     */
    private function removeEvent(Event $event): void
    {
        $sets = $this->getCriteriaSets(...$event->getCriteria());
        foreach ($sets as $set) {
            $this->client->zRem($set, $event->getId());
        }
    }

    private function getCriteriaSets(Criteria ...$criteria): array
    {
        return array_map(
            static fn (Criteria $criteria): string => "{$criteria->getName()}:{$criteria->getValue()}",
            $criteria
        );
    }
}
