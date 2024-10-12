<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use App\Elasticsearch\Search\QueryBuilder;
use App\Search\ClientInterface;
use App\Search\Data;
use Elastic\Elasticsearch\Client as ElasticsearchClient;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;

final readonly class Client implements ClientInterface
{
    private ElasticsearchClient $client;
    private string $indexName;

    public function __construct()
    {
        $this->indexName = getenv('ES_INDEX_NAME');

        try {
            $this->client = ClientBuilder::create()
                ->setHosts([getenv('ES_HOST') . ':' . getenv('ES_PORT')])
                ->setBasicAuthentication('username', 'password')
                ->setSSLVerification(false)
                ->build()
            ;

            $this->client->info();
        } catch (Exception $e) {
            printf("Проблема подключения к ElasticSearch: %s", $e->getMessage());
        }
    }

    public function search(Data $data): array
    {
        $query = new QueryBuilder();

        $params = [
            'index' => $this->indexName,
            'body' => $data->isEmpty() ? $query->all() : $query->fromData($data),
        ];

        return $this->client->search($params)->asArray();
    }

    public function bulk(array $payload): void
    {
        $this->client->bulk(['index' => $this->indexName, 'body' => $payload]);
    }

    public function createIndex(string $name, array $params = []): void
    {
        $this->client->indices()->create([
            'index' => $name,
            ...$params
        ]);
    }
}