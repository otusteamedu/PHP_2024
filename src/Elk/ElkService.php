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
        private readonly ElkRepository  $repository,
        private readonly ElkConsoleView $view,
    )
    {
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
                                    'type' => 'short',
                                ],
                            ],
                        ],
                    ],
                ],
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
    public function search(array $searchArgs): void
    {
        $query = new ElkBookSearchQuery(
            self::INDEX_NAME,
            title: $searchArgs['title'] ?? null,
            category: $searchArgs['category'] ?? null,
            lessThanPrice: isset($searchArgs['ltePrice']) ? (int)$searchArgs['ltePrice'] : null,
            graterThanPrice: isset($searchArgs['gtPrice']) ? (int)$searchArgs['gtPrice'] : null,
            shopName: $searchArgs['shopName'] ?? null,
        );

        $result = $this->repository->search($query);
        $this->view->render($result);
    }
}
