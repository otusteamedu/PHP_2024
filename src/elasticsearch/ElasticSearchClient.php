<?php

namespace AKornienko\Php2024\elasticsearch;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Transport\Exception\NoNodeAvailableException;
use RuntimeException;

class ElasticSearchClient
{
    private $client;
    public function __construct(string $host, string $username, $password) {
        $this->client = ClientBuilder::create()
            ->setHosts([$host])
            ->setBasicAuthentication($username, $password)
            ->setSSLVerification(false)
            ->build();
    }

    public function bulk(string $index, string $data): void {
        try {
            $this->client->bulk([
                'index' => $index,
                'body'  => $data,
            ]);
        } catch (ClientResponseException | ServerResponseException $e) {
            print_r($e->getMessage());
            throw new RuntimeException($e->getMessage());
        }
    }

    public function search($searchParams) {
        $elkSearchParams = new ELKQueryParams($searchParams, getenv("ELK_INDEX_NAME"));
        $results = $this->client->search($elkSearchParams->getParams())->asArray();
        return $results['hits'];
    }
}