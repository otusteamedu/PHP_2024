<?php

declare(strict_types=1);

namespace Alogachev\Homework\Elk;

use Alogachev\Homework\Exception\InvalidTestDataException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class ElkService
{
    private const INDEX_NAME = 'otus-shop';
    private const INDEX_ALIAS = 'books';
    public function __construct(
        private readonly ElkRepository $repository
    ) {
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function createAndFillBooksIndex(string $testDataPath): void
    {
        $params = [
            'index' => self::INDEX_NAME,
            'alias' => self::INDEX_ALIAS,
            'body' => [
                'settings' => [
                    'number_of_shards' => 1,
                    'number_of_replicas' => 0,
                    'analysis' => [
                        'analyzer' => [
                            'default' => [
                                'type' => 'russian',
                            ],
                        ],
                    ],
                ],
                'mappings' => [
                    'properties' => [
                        'title' => [
                            'type' => 'text',
                            'analyzer' => 'russian',
                        ],
                        'sku' => [
                            'type' => 'keyword',
                        ],
                        'category' => [
                            'type' => 'keyword',
                        ],
                        'price' => [
                            'type' => 'integer',
                        ],
                        'stock' => [
                            'type' => 'nested',
                            'properties' => [
                                'shop' => [
                                    'type' => 'keyword',
                                ],
                                'stock' => [
                                    'type' => 'integer',
                                ]
                            ]
                        ],
                    ]
                ]
            ],
        ];

        $this->repository->createIndex(self::INDEX_NAME, $params);
        // Заполняем индекс данными для тестирования.
        $fullPath = dirname(__DIR__) . '/' . $testDataPath;
        $bulkData = file_get_contents($fullPath);
        if (!$bulkData) {
            throw new InvalidTestDataException($fullPath);
        }
        $this->repository->bulk($bulkData);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function getClusterHealthCheckArray(): array
    {
        $health = $this->repository->getHealth();

        return $health->asArray();
    }
}
