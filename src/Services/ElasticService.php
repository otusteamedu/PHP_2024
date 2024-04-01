<?php

declare(strict_types=1);

namespace Pozys\OtusShop\Services;

use Elastic\Elasticsearch\Response\Elasticsearch;
use Exception;
use Pozys\OtusShop\Elastic\{
    BooleanQueryBuilder,
    DataLoader,
    DocumentSearch,
    IndexManager,
};

class ElasticService
{
    public const ALLOWED_OPERATORS = [
        '>=' => 'gte',
        '>' => 'gt',
        '=' => 'eq',
        '<' => 'lt',
        '<=' => 'lte',
    ];

    public function __construct(
        private IOProcessor $IOProcessor,
        private DataLoader $loader,
        private DocumentSearch $documentSearch,
        private BooleanQueryBuilder $booleanQueryBuilder,
        private IndexManager $indexManager,
    ) {
    }

    public function bulk(string $path): bool
    {
        $index = $this->IOProcessor->readJSON($path);
        $request = $this->indexManager->buildIndexRequest($index);

        return $this->loader->index($request);
    }

    public function search(array $data): array
    {
        $prepared = $this->prepareSearchRequest($data);
        $request = $this->documentSearch->buildSearchRequest($prepared);
        $result = $this->documentSearch->search($request);

        return $this->parseSearchResponse($result);
    }

    public function prepareSearchRequest(array $data): array
    {
        $query = $data['query'];
        if (!$this->isValid($query)) {
            throw new Exception('Invalid query');
        }

        return $this->processSearchData($query);
    }

    public function parseSearchResponse(Elasticsearch $response): array
    {
        $result = [];

        if (!array_key_exists('hits', $response->asArray())) {
            return [];
        }

        foreach ($response->asArray()['hits']['hits'] as $hit) {
            $row = [
                'id' => $hit['_id'],
                'title' => $hit['_source']['title'],
                'category' => $hit['_source']['category'],
                'price' => $hit['_source']['price'],
            ];

            $result[] = $row;
        }

        return $result;
    }

    public function initIndex(): void
    {
        $indexName = getenv('INDEX_NAME');

        if ($this->indexManager->indexExists($indexName)) {
            return;
        }

        $this->indexManager->createIndex($indexName);
        $this->bulk(getenv('INDEX_FILE_PATH'));
    }

    private function isValid(array $data): bool
    {
        if (
            array_key_exists('operator', $data)
            && !in_array($data['operator'], array_keys(self::ALLOWED_OPERATORS))
        ) {
            return false;
        }

        if (
            array_key_exists('price', $data) && !is_numeric($data['price'])
        ) {
            return false;
        }

        if (
            array_key_exists('in_stock', $data) && !is_bool($data['in_stock'])
        ) {
            return false;
        }

        return true;
    }

    private function processSearchData(array $data): array
    {
        if (array_key_exists('operator', $data)) {
            $data = $this->prepareOperator($data);
        }

        return $data;
    }

    private function prepareOperator(array $data): array
    {
        $data['operator'] = self::ALLOWED_OPERATORS[$data['operator']];

        return $data;
    }
}
