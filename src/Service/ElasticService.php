<?php

namespace KRudenko\Otus\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use KRudenko\Otus\Service\Elastic\ElasticQueryBuilder;
use RuntimeException;

readonly class ElasticService
{
    public function __construct(
        private Client $client
    ) {
    }

    public function bulk(array $document): bool
    {
        $params = [
            'index' => $_ENV['ELASTIC_INDEX'],
            'body'  => $document
        ];

        try {
            return $this->client->bulk($params)->asBool();
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException('Bulk failed: ' . $e->getMessage());
        }
    }

    public function search(string $title, array $price, bool $inComment, int $page): array
    {
        $queryBuilder = new ElasticQueryBuilder($this->client);

        if (!empty(trim($title))) {
            $queryBuilder->matchText('title', $title);
        }

        $priceConditions = ElasticQueryBuilder::parsePriceConditions($price);
        if (!empty($priceConditions)) {
            $queryBuilder->filterRange('price', $priceConditions);
        }

        if ($inComment) {
            $queryBuilder->filterRange('reviews_count', [['operator' => 'gt', 'value' => 0]]);
        }

        $queryBuilder->paginate($page);

        return $queryBuilder->execute();
    }
}
