<?php

namespace App\Templates;

use App\App;
use App\DTO\ElasticSearchResponse;
use App\DTO\SearchResponse;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

final class DefaultTemplate
{
    public function __construct(private readonly string $title, private readonly int $price)
    {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function search(): SearchResponse
    {
        $raw = App::$instance->elastic->client->search($this->prepare())->asArray();

        return new SearchResponse($raw);
    }

    public function prepare(): array
    {
        return [
            'index' => 'otus-shop',
            'body'  => [
                'query' => [
                    'bool' => [
                        'must' => [
                            [
                                'match' => [
                                    'title' => [
                                        'query' => $this->title,
                                        'fuzziness' => 'AUTO'
                                    ]
                                ]
                            ]
                        ],
                        'filter' => [
                            [
                                'term' => [
                                    'category' => 'Исторический роман'
                                ]
                            ],
                            [
                                'range' => [
                                    'price' => [
                                        'lte' => $this->price
                                    ]
                                ]
                            ],
                            [
                                'nested' => [
                                    'path' => 'stock',
                                    'query' => [
                                        'bool' => [
                                            'should' => [
                                                ['range' => ['stock.stock' => ['gt' => 0]]]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}
