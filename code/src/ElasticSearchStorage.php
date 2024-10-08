<?php

namespace  Naimushina\ChannelManager;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Elastic\Transport\Exception\NoNodeAvailableException;
use Exception;
use Http\Promise\Promise;

class ElasticSearchStorage
{
    private \Elastic\Elasticsearch\Client $client;

    /**
     * @throws AuthenticationException
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['elastic:9200'])
            ->setBasicAuthentication('username', 'password')
            ->setSSLVerification(false)
            ->build();

        try {
             $this->client->info();
        } catch (Exception $e) {
            printf("Проблема подключения к ElasticSearch: %s", $e->getMessage());
        }

    }

    /**
     * @param string $name
     * @param array $params
     * @return Elasticsearch|Promise
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function createIndex(string $name, array $params = []): Elasticsearch|Promise
    {
        $params = [
            'index' => $name,
            ...$params
        ];
        return $this->client->indices()->create($params);
    }

    /**
     * @param string $name
     * @return Elasticsearch
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function deleteIndex(string $name): Elasticsearch
    {
        return $this->client->indices()->delete(['index' => $name]);
    }


    /**
     * @param array $mapping
     * @return Elasticsearch|Promise
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function addMapping(array $mapping): Elasticsearch|Promise
    {
        return $this->client->indices()->putMapping($mapping);
    }


    public function addDocument(string $index, array $documentBody, $documentId = null): Elasticsearch
    {
        $params = [
            'index' => $index,
            'body' => $documentBody,
        ];
        if($documentId){
            $params['id'] = $documentId;
        }
        return $this->client->index($params);
    }
    public function deleteDocument(string $index, int $documentId ): Elasticsearch
    {
        $params = [
            'index' => $index,
            'id' => $documentId,
        ];
        return $this->client->delete($params);
    }

    public function search(string $index, array $body): array
    {
        $params = [
            'index' => $index,
            'body' => $body
        ];

        $response = $this->client->search($params);

        return $response->asArray();
    }

}