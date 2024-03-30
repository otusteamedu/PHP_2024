<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Infrastructure\Repository\Elastic;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Rmulyukov\Hw\Application\Event\Event;
use Rmulyukov\Hw\Application\Repository\EventCommandRepositoryInterface;

final readonly class ElasticEventCommandRepository extends AbstractElasticRepository implements EventCommandRepositoryInterface
{
    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function add(Event $event): bool
    {
        $body = [
            'priority' => $event->getPriority(),
        ];
        foreach ($event->getCriteria() as $criteria) {
            $body[$criteria->getName()] = $criteria->getValue();
        }

        $this->client->create([
            'index' => 'events',
            'id' => $event->getId(),
            'body' => $body
        ]);

        return true;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function clear(): bool
    {
        $this->client->indices()->delete(['index' => 'events']);
        return true;
    }
}
