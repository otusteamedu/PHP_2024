<?php

declare(strict_types=1);

namespace Alogachev\Homework\Elk;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;

class ElkRepository
{
    public function __construct(
        private readonly Client $client
    )
    {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function createIndex(string $indexName, array $params): void
    {
        $exists = $this->client->indices()->exists(['index' => $indexName])->getStatusCode();
        if (
            $exists === ElkStatusDictionary::STATUS_OK
        ) {
            echo "Index $indexName already exists" . PHP_EOL;
            return;
        }

        $this->client->indices()->create($params);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function bulk(string $bulkData): void
    {
        $this->client->bulk(['body' => $bulkData]);
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function getHealth(): Elasticsearch
    {
        return $this->client->cluster()->health();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(
        string $indexName,
        string $title,
        int    $lessThanPrice,
        int    $graterThanPrice,
        string $category,
    ): Elasticsearch
    {
        return $this->client->search([
            'index' => $indexName,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'title' => [
                                        'query' => $title,
                                        'fuzziness' => 'AUTO',
                                    ],
                                ],
                            ],
                        ],
                        'filter' => [
                            [
                                'range' => [
                                    'price' => [
                                        'gte' => $graterThanPrice,
                                        'lt' => $lessThanPrice,
                                    ],
                                ],
                            ],
                            [
                                'nested' => [
                                    'path' =>'stock',
                                    'query' => [
                                        'bool' => [
                                           'filter' => [
                                                [
                                                   'range' => [
                                                       'stock.stock' => [
                                                           'gte' => 0,
                                                       ],
                                                    ],
                                                ],
                                               [
                                                   'term' => [
                                                       'stock.shop' => 'Ленина',
                                                   ],
                                               ]
                                            ],

                                        ],
                                    ],
                                ],
                            ],
                            [
                                'term' => [
                                    'category' => $category,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
