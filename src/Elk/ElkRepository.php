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
    public function search(ElkBookSearchQuery $query): Elasticsearch
    {
        $baseQuery = [
            'index' => $query->getIndexName(),
            'body' => [
                'query' => [
                    'bool' => [],
                ]
            ],
        ];

        if (!is_null($query->getTitle())) {
            $baseQuery['body']['query']['bool']['must'][] = [
                'match' => [
                    'title' => [
                        'query' => $query->getTitle(),
                        'fuzziness' => 'AUTO',
                    ],
                ],
            ];
        }

        if (!is_null($query->getCategory())) {
            $baseQuery['body']['query']['bool']['filter'][] = [
                'term' => [
                    'category' => $query->getCategory(),
                ],
            ];
        }

        if (!is_null($query->getLessThanPrice()) || !is_null($query->getGraterThanPrice())) {
            $range = [
                'range' => [
                    'price' => [
                    ],
                ],
            ];
            if (!is_null($query->getLessThanPrice())) {
                $range['range']['price']['lt'] = $query->getLessThanPrice();
            }
            if (!is_null($query->getGraterThanPrice())) {
                $range['range']['price']['gt'] = $query->getGraterThanPrice();
            }

            $baseQuery['body']['query']['bool']['filter'][] = $range;
        }

        return $this->client->search([
            'index' => $query->getIndexName(),
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'title' => [
                                        'query' => $query->getTitle(),
                                        'fuzziness' => 'AUTO',
                                    ],
                                ],
                            ],
                        ],
                        'filter' => [
                            [
                                'range' => [
                                    'price' => [
                                        'gte' => $query->getGraterThanPrice(),
                                        'lt' => $query->getLessThanPrice(),
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
                                                       'stock.shop' => $query->getShopName(),
                                                   ],
                                               ]
                                            ],

                                        ],
                                    ],
                                ],
                            ],
                            [
                                'term' => [
                                    'category' => $query->getCategory(),
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
