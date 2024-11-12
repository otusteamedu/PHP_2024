<?php

namespace VSukhov\Hw12\Infostructure\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticSearchService
{
    private Client $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setBasicAuthentication('elastic', 'cc51da887b8187d3e911b12376b1e283808ad062a137212a15a45e229123de1f')
            ->setHosts(['localhost:9200'])
            ->build();
    }

    public function search(string $indexName, array $query)
    {
        return $this->client->search([
            'index' => $indexName,
            'body'  => $query,
        ]);
    }

    public function indexDocument($indexName, $document)
    {
        if (!empty($document)) {
            $this->client->index([
                'index' => $indexName,
                'body'  => $document,
            ]);
            echo $document['title'];
        }
    }
}
