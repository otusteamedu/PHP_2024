<?php

declare(strict_types=1);

namespace AlexanderGladkov\Bookshop\Index;

use AlexanderGladkov\Bookshop\Elasticsearch\ElasticsearchClient;

class Index
{
    private string $indexName = 'otus-shop';

    public function __construct(private readonly ElasticsearchClient $elasticsearchClient)
    {
    }

    public function deleteIfExists(): void
    {
        if ($this->elasticsearchClient->isIndexExists($this->indexName)) {
            $this->elasticsearchClient->deleteIndex($this->indexName);
        }
    }

    public function create(): void
    {
        $this->elasticsearchClient->createIndex($this->indexName);
        $this->elasticsearchClient->createSettings($this->indexName, $this->getSettingsDescription());
        $this->elasticsearchClient->createMappings($this->indexName, $this->getMappingsDescription());
    }

    public function fillByString(string $indexData): void
    {
        $this->elasticsearchClient->bulkString($indexData, $this->indexName);
    }

    public function fillByArray(array $indexData): void
    {
        $this->elasticsearchClient->bulkArray($indexData, $this->indexName);
    }

    public function search(SearchParams $searchParams): SearchResult
    {
        $result = $this->elasticsearchClient->search($this->indexName, $searchParams->generateSearchRequestBody());
        $totalCount = (int)$result['hits']['total']['value'];
        $hits = array_column($result['hits']['hits'], '_source');
        return new SearchResult($totalCount, $hits);
    }

    private function getSettingsDescription(): array
    {
        return [
            'analysis' => [
                'filter' => [
                    'ru_stop' => [
                        'type' => 'stop',
                        'stopwords' => '_russian_'
                    ],
                    'ru_stemmer' => [
                        'type' => 'stemmer',
                        'language' => 'russian',
                    ],
                ],
                'analyzer' => [
                    'russian_language' => [
                        'tokenizer' => 'standard',
                        'filters' => [
                            'lowercase',
                            'ru_stop',
                            'ru_stemmer',
                        ],
                    ],
                ],
            ],
        ];
    }

    private function getMappingsDescription(): array
    {
        return  [
            '_source' => [
                'enabled' => true,
            ],
            'properties' => [
                'sku' => [
                    'type' => 'keyword',
                ],
                'title' => [
                    'type' => 'text',
                    'analyzer' => 'russian_language',
                    'fields' => [
                        'keyword' => [
                            'type' => 'keyword',
                            'ignore_above' => 256,
                        ],
                    ],
                ],
                'category' => [
                    'type' => 'keyword',
                ],
                'price' => [
                    'type' => 'long'
                ],
                'stock' => [
                    'type' => 'nested',
                    'properties' => [
                        'shop' => [
                            'type' => 'text',
                            'analyzer' => 'russian_language',
                        ],
                        'stock' => [
                            'type' => 'short',
                        ],
                    ],
                ],
            ],
        ];
    }
}
