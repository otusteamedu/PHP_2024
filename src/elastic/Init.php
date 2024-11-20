<?php

declare(strict_types=1);

namespace hw14\elastic;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;
use hw14\Dictionary;

class Init implements ElasticInterface
{
    private Client $client;

    private $logs = [];

    private string $indexName;

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

    public function exec()
    {
        $this->deleteIndex();
        $this->createIndex();
        $this->loadData();

        return json_encode($this->logs);
    }

    private function deleteIndex(): void
    {
        $result = $this->client->indices()->exists([
            'index' => $this->indexName
        ]);

        if (empty($result->asBool())) {
            return;
        }

        $result = $this->client->indices()->delete([
            'index' => $this->indexName
        ]);

        $this->logs[] = $result->asString();
    }

    private function createIndex()
    {
        $result = $this->client->indices()->create([
            'index' => $this->indexName,
            'body' => Dictionary::INDEX_SETTING
        ]);

        $this->logs[] = $result->asString();
    }

    private function loadData()
    {
        $result = $this->client->bulk([
            'index' => $this->indexName,
            'body' => ['data-binary' => file_get_contents(BASE_PATH . '/books.json')]
        ]);

        $this->logs[] = $result->asString();
    }
}
