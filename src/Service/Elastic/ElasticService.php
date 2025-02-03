<?php

namespace KRudenko\Otus\Service\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use KRudenko\Otus\Service\SearchServiceInterface;
use RuntimeException;

readonly class ElasticService implements SearchServiceInterface
{
    public function __construct(
        private Client $client,
        private ElasticQueryBuilder $elasticQueryBuilder,
    ) {
    }

    public function bulk(array $document, string $index): bool
    {
        $params = [
            'index' => $index ?: $_ENV['ELASTIC_INDEX'],
            'body'  => $document
        ];

        try {
            return $this->client->bulk($params)->asBool();
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException('Bulk failed: ' . $e->getMessage());
        }
    }

    public function search(array $criteria, int $page, string $index): array
    {
        $params = [
            'index' => $index ?: $_ENV['ELASTIC_INDEX'],
            'body'  => $this->elasticQueryBuilder->buildQuery($criteria),
            'from'  => ($page - 1) * $_ENV['PAGE_SIZE'],
            'size'  => $_ENV['PAGE_SIZE'],
        ];

        try {
            $response = $this->client->search($params);
            return $response->asArray();
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException('Search failed: ' . $e->getMessage());
        }
    }
}
