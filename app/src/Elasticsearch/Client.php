<?php

declare(strict_types=1);

namespace App\Elasticsearch;

use App\Elasticsearch\Search\QueryBuilder;
use App\Exception\ClientException;
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
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function search(Data $data): array
    {
        $query = new QueryBuilder();

        $params = [
            'index' => $this->indexName,
            'body' => $data->isEmpty() ? $query->all() : $query->fromData($data),
        ];

        try {
            return $this->client->search($params)->asArray();
        } catch (Exception $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function bulk(array $payload): void
    {
        try {
            $this->client->bulk(['index' => $this->indexName, 'body' => $payload]);
        } catch (Exception $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function createIndex(string $name, array $params = []): void
    {
        try {
            $this->client->indices()->create([
                'index' => $name,
                ...$params
            ]);
        } catch (Exception $e) {
            throw new ClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
