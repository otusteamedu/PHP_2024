<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Infrastructure\Repository\Elastic;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Rmulyukov\Hw\Application\Event\Criteria;
use Rmulyukov\Hw\Application\Event\Event;
use Rmulyukov\Hw\Application\Factory\EventFactory;
use Rmulyukov\Hw\Application\Repository\EventQueryRepositoryInterface;

final readonly class ElasticEventQueryRepository extends AbstractElasticRepository implements EventQueryRepositoryInterface
{
    public function __construct(
        private EventFactory $factory,
        string $host,
        int $port
    ) {
        parent::__construct($host, $port);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function getByCriteria(Criteria $criteria, Criteria ...$criterias): Event
    {
        $res = $this->client->search([
            'index' => 'events',
            'body' => (new Query())->prepare($criteria, ...$criterias)
        ])->asArray();

        $event = $res['hits']['hits'][0];
        $priority = $event['_source']['priority'];
        unset($event['_source']['priority']);

        return $this->factory->create((int) $event['_id'], (int) $priority, $event['_source']);
    }
}
