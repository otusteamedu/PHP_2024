<?php

declare(strict_types=1);

namespace AleksandrOrlov\Php2024\Indexes;

use AleksandrOrlov\Php2024\IndexInterface;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Client;
use AleksandrOrlov\Php2024\Helper;

class OtusShop implements IndexInterface
{
    private array $searchParams;

    public function __construct(private readonly string $name, private readonly Client $client)
    {
        $this->initSearch();
    }

    private function initSearch(): void
    {
        $this->searchParams = [
            'index' => $this->name,
            'from' => 0,
            'size' => 10,
            'body' => [
                'query' => [
                    'bool' => [
                        'must' => [],
                        'filter' => [
                            [
                                'nested' => [
                                    'path' => 'stock',
                                    'query' => [
                                        'bool' => [
                                            'must' => []
                                        ]
                                    ]
                                ],
                            ]
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function create(): void
    {
        if ($this->client->indices()->exists(['index' => $this->name])->getStatusCode() === 404) {
            $this->client->indices()->create([
                'index' => $this->name,
                'body'  => $this->getMap(),
            ]);
        }
    }

    /**
     * @return \array[][]
     */
    private function getMap(): array
    {
        return [
            "settings" => [
                "analysis" => [
                    "filter"   => [
                        "ru_stop"    => [
                            "type"      => "stop",
                            "stopwords" => "_russian_"
                        ],
                        "ru_stemmer" => [
                            "type"     => "stemmer",
                            "language" => "russian"
                        ]
                    ],
                    "analyzer" => [
                        "lang_russian" => [
                            "tokenizer" => "standard",
                            "filter"    => [
                                "lowercase",
                                "ru_stop",
                                "ru_stemmer"
                            ]
                        ]
                    ]
                ]
            ],
            "mappings" => [
                "properties" => [
                    "title"    => [
                        "type"     => "text",
                        "analyzer" => "lang_russian"
                    ],
                    "sku"      => [
                        "type" => "text"
                    ],
                    "category" => [
                        "type"     => "keyword",
                    ],
                    "price"    => [
                        "type" => "long"
                    ],
                    "stock"    => [
                        "type"       => "nested",
                        "properties" => [
                            "shop"  => [
                                "type"     => "text",
                                "analyzer" => "lang_russian"
                            ],
                            "stock" => [
                                "type" => "integer"
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    private function setTitle(string $title): void
    {
        $this->searchParams['body']['query']['bool']['must'] = [
            'match' => [
                'title' => [
                    'query' => $title,
                    'fuzziness' => 'auto',
                    'operator' => 'and',
                ],
            ]
        ];
    }

    private function setCategory(string $category): void
    {
        $this->searchParams['body']['query']['bool']['filter'][] = [
            'match' => [
                'category' => $category,
            ]
        ];
    }

    private function setPrice(string $price): void
    {
        $price = Helper::transformOperator($price);

        $this->searchParams['body']['query']['bool']['filter'][] = [
            'range' => [
                'price' => $price
            ]
        ];
    }

    private function setStock(string $count): void
    {
        $count = Helper::transformOperator($count);
        $this->searchParams['body']['query']['bool']['filter'][0]['nested']['query']['bool']['must'] = [
            'range' => [
                'stock.stock' => $count
            ]
        ];
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(array $options): Elasticsearch|Promise
    {
        $commands = $this->prepareSearchParams($options);

        if (array_key_exists('title', $commands)) {
            $this->setTitle($commands['title']);
        }

        if (array_key_exists('category', $commands)) {
            $this->setCategory($commands['category']);
        }

        if (array_key_exists('price', $commands)) {
            $this->setPrice($commands['price']);
        }

        if (array_key_exists('stock', $commands)) {
            $this->setStock($commands['stock']);
        }

        return $this->client->search($this->searchParams);
    }

    /**
     * @param array $options
     * @return array
     */
    private function prepareSearchParams(array $options): array
    {
        $params = [];

        if (isset($options['t'])) {
            $params['title'] = $options['t'];
        }

        if (isset($options['c'])) {
            $params['category'] = $options['c'];
        }

        if (isset($options['p'])) {
            $params['price'] = $options['p'];
        }

        if (isset($options['s'])) {
            $params['stock'] = $options['s'];
        }

        return $params;
    }
}
