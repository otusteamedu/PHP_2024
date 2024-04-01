<?php

declare(strict_types=1);

namespace Pozys\OtusShop\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Pozys\OtusShop\Services\ElasticService;

class DocumentSearch
{
    private Client $client;

    public function __construct(
        private Connection $connection,
        private BooleanQueryBuilder $booleanQueryBuilder,
    ) {
        $this->client = $this->connection->getClient();
    }

    public function search(array $params): Elasticsearch
    {
        $results = $this->client->search($params);

        return $results;
    }

    public function buildSearchRequest(array $data): array
    {
        $request = RequestBuilder::baseRequest();
        $request['size'] = getenv('PAGE_SIZE');

        $queryBuilder = $this->booleanQueryBuilder;

        if (array_key_exists('category', $data)) {
            $query = BooleanQueryBuilder::term('category', $data['category']);
            $queryBuilder = $queryBuilder->addFilter($query);
        }

        if (array_key_exists('title', $data)) {
            $query = BooleanQueryBuilder::match('title', $data['title'], true);
            $queryBuilder = $queryBuilder->addMust($query);
        }

        if (array_key_exists('price', $data)) {
            $query = ($data['operator'] === 'eq')
                ? BooleanQueryBuilder::match('price', $data['price'])
                : BooleanQueryBuilder::range('price', $data['price'], $data['operator']);

            $queryBuilder = $queryBuilder->addMust($query);
        }

        if (array_key_exists('in_stock', $data)) {
            $query = BooleanQueryBuilder::range('stock.stock', 0, ElasticService::ALLOWED_OPERATORS['>']);
            $nested = BooleanQueryBuilder::nested('stock', $query);
            $queryBuilder = $queryBuilder->addMust($nested);
        }

        return RequestBuilder::setBody($request, ['query' => $queryBuilder->getQuery()]);
    }
}
