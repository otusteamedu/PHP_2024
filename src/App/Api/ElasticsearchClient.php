<?php

namespace App\Api;

use Elastic\Elasticsearch\ClientBuilder;
use \Elastic\Elasticsearch\Client;

class ElasticsearchClient
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['otus-elasticsearch:9200'])
            ->build();
    }

    public function createIndex(array $query): void
    {
        $this->client->indices()->create($query);
    }

    public function addDoc(array $query): void
    {
        $this->client->index($query);
    }

    public function deleteById(string $index, string $id): void
    {
        $query = [
            'index' => $index,
            'id' => $id
        ];

        $this->client->delete($query);
    }

    public function search(array $query)
    {
        return $this->client->search($query);
    }
}