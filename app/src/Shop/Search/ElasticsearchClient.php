<?php

declare(strict_types=1);

namespace App\Shop\Search;

use App\Shared\Exception\SearchClientException;
use App\Shared\Search\SearchClientInterface;
use App\Shared\Search\SearchCriteria;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;

final readonly class ElasticsearchClient implements SearchClientInterface
{
    private Client $client;

    public function __construct()
    {
        try {
            $this->client = ClientBuilder::create()
                ->setHosts([getenv('ES_HOST') . ':' . getenv('ES_PORT')])
                ->setBasicAuthentication(getenv('ES_USERNAME'), getenv('ES_PASSWORD'))
                ->setSSLVerification(false)
                ->build()
            ;

            $this->client->info();
        } catch (Exception $e) {
            throw new SearchClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function search(string $indexName, ?SearchCriteria $searchCriteria = null): array
    {
        $query = new SearchQueryBuilder();

        $params = [
            'index' => $indexName,
            'body' => $query->fromSearchCriteria($searchCriteria),
        ];

        try {
            return $this->client->search($params)->asArray()['hits']['hits'] ?? [];
        } catch (Exception $e) {
            throw new SearchClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function createIndex(string $name, array $schema = []): void
    {
        try {
            $this->client->indices()->create([
                'index' => $name,
                ...$schema
            ]);
        } catch (Exception $e) {
            throw new SearchClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function deleteIndex(string $name): void
    {
        $params = ['index' => $name];

        try {
            if (!$this->client->indices()->exists($params)->asBool()) {
                return;
            }

            $this->client->indices()->delete($params);
        } catch (Exception $e) {
            throw new SearchClientException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function bulk(string $indexName, array $data): void
    {
        try {
            $this->client->bulk(['index' => $indexName, 'body' => $data]);
        } catch (Exception $e) {
            throw new SearchClientException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
