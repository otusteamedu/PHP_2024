<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Elasticsearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use LogicException;
use RuntimeException;

class ElasticsearchClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->client->setResponseException(true);
    }

    public function isIndexExists(string $indexName): bool
    {
        try {
            $response = $this->client->indices()->exists(['index' => $indexName]);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                return true;
            }

            if ($statusCode === 404) {
                return false;
            }

            throw new RuntimeException($response->asString());
        } catch (MissingParameterException $e) {
            throw new LogicException($e->getMessage());
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function createIndex(string $indexName): void
    {
        try {
            $this->client->indices()->create(['index' => $indexName]);
        } catch (MissingParameterException $e) {
            throw new LogicException($e->getMessage());
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function createSettings(string $indexName, array $settings): void
    {
        try {
            $this->client->indices()->close(['index' => $indexName]);
            $this->client->indices()->putSettings([
                'index' => $indexName,
                'body' => $settings,
            ]);
            $this->client->indices()->open(['index' => $indexName]);
        } catch (MissingParameterException $e) {
            throw new LogicException($e->getMessage());
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function createMappings(string $indexName, array $mappings): void
    {
        try {
            $this->client->indices()->putMapping([
                'index' => $indexName,
                'body' => $mappings,
            ]);
        } catch (MissingParameterException $e) {
            throw new LogicException($e->getMessage());
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function deleteIndex(string $indexName)
    {
        try {
            $this->client->indices()->delete(['index' => $indexName]);
        } catch (MissingParameterException $e) {
            throw new LogicException($e->getMessage());
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function search(string $indexName, array $body): array
    {
        try {
            $response = $this->client->search([
                'index' => $indexName,
                'body' => $body
            ]);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                return $response->asArray();
            }

            throw new RuntimeException($response->asString());
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public function bulkArray(array $data, ?string $defaultIndexName = null, int $batchSize = 1000): void
    {
        $i = 0;
        $batchSizeCounter = 0;
        $body = [];
        while ($i < count($data)) {
            $body[] = $data[$i++]; // operation
            $body[] = $data[$i++]; // operation data
            $batchSizeCounter++;
            if ($batchSizeCounter === $batchSize) {
                $this->performBulkArrayRequest($body, $defaultIndexName);
                $body = [];
                $batchSizeCounter = 0;
            }
        }

        if (count($body) > 0) {
            $this->performBulkArrayRequest($body, $defaultIndexName);
        }
    }

    public function bulkString(string $data, ?string $defaultIndexName = null): void
    {
        $params = ['body' => $data];
        if ($defaultIndexName !== null) {
            $params['index'] = $defaultIndexName;
        }

        try {
            $this->client->bulk($params);
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    private function performBulkArrayRequest(array $body, ?string $defaultIndexName = null)
    {
        $params = ['body' => $body];
        if ($defaultIndexName !== null) {
            $params['index'] = $defaultIndexName;
        }

        try {
            $this->client->bulk($params);
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}
