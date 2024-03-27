<?php

declare(strict_types=1);

namespace Rmulyukov\Hw11\Repository;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Rmulyukov\Hw11\Application\Query\ElasticQuery;
use Rmulyukov\Hw11\Application\Repository\ShopQueryRepositoryInterface;
use Rmulyukov\Hw11\Application\Dto\QueryDto;

final class ShopQueryElasticRepository implements ShopQueryRepositoryInterface
{
    private Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct(
        private string $host,
        private ElasticQuery $queryConverter,
    ) {
        $this->client = ClientBuilder::create()->setHosts([$this->host])->build();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function findAll(string $storageName, QueryDto $query): array
    {
        return $this->client->search([
            'index' => $storageName,
            'body' => $this->queryConverter->prepare($query)
        ])->asArray();
    }
}
