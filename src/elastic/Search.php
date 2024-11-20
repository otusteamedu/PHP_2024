<?php

declare(strict_types=1);

namespace hw14\elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class Search implements ElasticInterface
{
    private Client $client;

    private string $indexName;

    private array $query;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([getenv('ELASTIC_HOST')])
            ->setBasicAuthentication(
                getenv('ELASTIC_USERNAME'),
                getenv('ELASTIC_PASSWORD')
            )
            ->build();

        $this->indexName = getenv('ELASTIC_INDEX');
    }

    public function setQuery(string $value)
    {
        $this->query = json_decode($value, true);
    }

    public function exec()
    {
        $result = $this->client->search([
            'index' => $this->indexName,
            'body' => $this->query
        ]);

        return $result->asString();
    }
}
