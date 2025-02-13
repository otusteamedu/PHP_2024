<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticStorage implements Storage
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['elasticsearch:9200'])
            ->build();
    }

    public function search(array $params): array
    {
        $response = $this->client->search($params);
        return $response['hits']['hits'];
    }
}
