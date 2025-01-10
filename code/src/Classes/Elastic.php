<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw10\Classes;

use Asyrovatkin\Hw10\Models\YoutubeStatRecord;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

class Elastic
{
    private Client $client;
    private string $indexName;

    /**
     * @throws AuthenticationException
     */
    public function __construct($indexName)
    {
        $this->client = $this->getClient();
        $this->indexName = $indexName;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createIndex($removeIfExist = 0, $mapping = null): void
    {
        if ($removeIfExist && $this->client->indices()->exists(['index' => $this->indexName])->asBool()) {
            $this->deleteIndex();
        }

        if (!$this->client->indices()->exists(['index' => $this->indexName])->asBool()) {
            $params = ['index' => $this->indexName];
            if ($mapping !== null) {
                $params['body'] = $mapping;
            }
            $this->client->indices()->create($params);
        }
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function deleteIndex(): void
    {
        $this->client->indices()->delete(['index' => $this->indexName]);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function addDocument(YoutubeStatRecord $youtubeStatRecord): void
    {
            $document = $youtubeStatRecord->toArray();
            $this->client->create(['index' => $this->indexName, 'body' => $document]);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function deleteDocument(string $documentId): void
    {
        $this->client->delete(['index' => $this->indexName, 'id' => $documentId]);
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function addBatch($documents): void
    {
        $this->client->bulk(['index' => $this->indexName, 'body' => $documents]);
    }

    /**
     * @param array $params
     * @return Elasticsearch
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(array $params = []): Elasticsearch
    {
        return $this->client->search($params);
    }

    /**
     * @return Client
     * @throws AuthenticationException
     */
    public function getClient(): Client
    {
        return ClientBuilder::create()
            ->setHosts(['elastic:9200'])
            ->setBasicAuthentication('elastic', 'MyPw123')
            ->build();
    }
}