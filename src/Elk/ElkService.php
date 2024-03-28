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
    public function createAndFillBooksIndex(string $dataPath): void
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

        $bulkData = file_get_contents($dataPath);
        if (!$bulkData) {
            throw new InvalidTestDataException($dataPath);
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

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(): void
    {
        $title = 'Рживский';

        $result = $this->repository->search(self::INDEX_NAME, $title);
        if (empty($result['hits']['hits'])) {
            echo '====================================================================' . PHP_EOL;
            echo 'Не удалось ничего найти' . PHP_EOL;
        }
        echo '====================================================================' . PHP_EOL;

        foreach ($result['hits']['hits'] as $book) {
            echo 'Код: ' . $book['_source']['sku'] . PHP_EOL;
            echo 'Наименование: ' . $book['_source']['title'] . PHP_EOL;
            echo 'Категория: ' . $book['_source']['category'] . PHP_EOL;
            echo 'Цена: ' . $book['_source']['price'] . PHP_EOL;
            echo 'В наличие: ' . PHP_EOL;
            foreach ($book['_source']['stock'] as $shop) {
                echo 'Магазин: ' . $shop['shop'] . PHP_EOL;
                echo 'Количество: ' . $shop['stock'] . PHP_EOL;
            }
            echo '====================================================================' . PHP_EOL;
        }
    }
}
