<?php

namespace AKornienko\Php2024\elasticsearch;

use AKornienko\Php2024\Config;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RuntimeException;

class ElasticSearchClient
{
    private \Elastic\Elasticsearch\Client $client;
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->client = ClientBuilder::create()
            ->setHosts([$config->hostUrl])
            ->setBasicAuthentication($config->userName, $config->password)
            ->setSSLVerification(false)
            ->build();
    }

    public function bulk(string $index, string $data): void
    {
        try {
            $this->client->bulk([
                'index' => $index,
                'body' => $data,
            ]);
        } catch (ClientResponseException|ServerResponseException $e) {
            print_r($e->getMessage());
            throw new RuntimeException($e->getMessage());
        }
    }

    public function search($searchParams)
    {
        $elkSearchParams = new ELKQueryParams($searchParams, $this->config->indexName);
        $results = $this->client->search($elkSearchParams->getParams())->asArray();
        return $results['hits'];
    }
}
