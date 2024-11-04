<?php

namespace VSukhov\Hw12\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;

class SearchService
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();
    }

    public function createIndex(string $indexName): void
    {
        $this->client->indices()->create(['index' => $indexName]);
    }

    public function indexDocument(string $indexName, array $document): void
    {
        $this->client->index([
            'index' => $indexName,
            'body'  => $document,
        ]);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(string $indexName, SearchQueryBuilder $queryBuilder): Elasticsearch|Promise
    {
        $query = $queryBuilder->getQuery();

        return $this->client->search([
            'index' => $indexName,
            'body'  => $query,
        ]);
    }
}
