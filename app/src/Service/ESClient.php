<?php

declare(strict_types=1);

namespace AlexanderPogorelov\ElasticSearch\Service;

use AlexanderPogorelov\ElasticSearch\Config;
use AlexanderPogorelov\ElasticSearch\Exception\ESException;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ESClient
{
    private Config $config;
    private Client $client;

    public function __construct()
    {
        $this->config = new Config();
        $this->client = $this->buildClient();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ESException
     */
    public function createIndexWithParams(string $indexName, array $settings, array $properties): void
    {
        $params = [
            'index' => $indexName,
            'body' => [
                'settings' => $settings,
                'mappings' => [
                    '_source' => [
                        'enabled' => true,
                    ],
                    'properties' => $properties,
                ]
            ]
        ];

        $result = $this->client->indices()->create($params)->asBool();

        if (!$result) {
            throw new ESException(sprintf('Unable to create index %s.', $indexName));
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ESException
     */
    public function deleteIndex(string $indexName): void
    {
        $result = $this->client->indices()->delete([
            'index' => $indexName,
        ])->asBool();

        if (!$result) {
            throw new ESException(sprintf('Unable to delete index %s.', $indexName));
        }
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function isIndexExist(string $indexName): bool
    {
        return $this->client->indices()->exists([
            'index' => $indexName,
        ])->asBool();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ESException
     */
    public function addWithId(string $indexName, string $id, string $json): void
    {
        $result = $this->client->create([
            'index' => $indexName,
            'id' => $id,
            'body' => $json,
        ])->asBool();

        if (!$result) {
            throw new ESException(sprintf('Unable to add data to index %s.', $indexName));
        }
    }

    public function getById(string $indexName, string $id): array
    {
        return $this->client->get([
            'index' => $indexName,
            'id' => $id,
        ])->asArray();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function bulkInsert(string $indexName, string $json): array
    {
        return $this->client->bulk([
            'index' => $indexName,
            'body' => $json,
        ])->asArray();
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function searchAll(string $indexName): array
    {
        $params = [
            'index' => $indexName,
            'body'  => [
                'query' => [
                    'match_all' => (object) []
                ]
            ]
        ];

        return $this->client->search($params)->asArray();
    }

    public function searchByTitle(string $indexName, string $title): array
    {
        $params = [
            'index' => $indexName,
            'body'  => [
                'query' => [
                    'match' => [
                        'title' => $title
                    ]
                ]
            ]
        ];

        return $this->client->search($params)->asArray();
    }

    public function searchByCategory(string $indexName, string $category): array
    {
        $params = [
            'index' => $indexName,
            'body'  => [
                'query' => [
                    'term' => [
                        'category' => $category
                    ]
                ]
            ]
        ];

        return $this->client->search($params)->asArray();
    }

    public function searchByQuery(string $indexName, array $query): array
    {
        $params = [
            'index' => $indexName,
            'body'  => [
                'query' => $query,
            ]
        ];

        return $this->client->search($params)->asArray();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function getMappings(string $indexName): array
    {
        return $this->client->indices()->getMapping([
            'index' => $indexName,
        ])->asArray();
    }

    /**
     * @throws AuthenticationException
     */
    private function buildClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts([$this->config->getHost()])
            ->setBasicAuthentication($this->config->getUsername(), getenv('ELASTIC_PASSWORD'))
            ->build();
    }
}
