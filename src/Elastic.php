<?php

namespace AleksandrOrlov\Php2024;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Elasticsearch\Response\Elasticsearch;
use Http\Promise\Promise;
use RuntimeException;

class Elastic
{
    private Client $client;

    private array $searchParams;

    private const INDEX_NAME = 'otus-shop';

    /**
     * @throws AuthenticationException
     */
    public function __construct(
        private string $host,
        private string $user,
        private string $password,
    ) {
        $this->connect();
        $this->initSearch();
    }

    /**
     * @throws AuthenticationException
     */
    private function connect(): void
    {
        $client = ClientBuilder::create()
            ->setHosts([$this->host])
            ->setSSLVerification(false)
            ->setBasicAuthentication($this->user, $this->password)
            ->build();

        $this->client = $client;
    }

    /**
     * Наполнение индекса данными из файла
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function bulk(string $filePath): void
    {
        $t = file_get_contents($filePath);
        $this->createIndex();
        try {
            $this->client->bulk([
                'index' => 'otus-shop',
                'body'  => file_get_contents($filePath),
            ]);
        } catch (ClientResponseException | ServerResponseException $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    private function createIndex(): void
    {
        if ($this->client->indices()->exists(['index' => 'otus-shop'])->getStatusCode() === 404) {
            $this->client->indices()->create([
                'index' => self::INDEX_NAME,
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

    private function initSearch(): void
    {
        $this->searchParams = [
            'index' => self::INDEX_NAME,
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
        $price = $this->transformOperator($price);

        $this->searchParams['body']['query']['bool']['filter'][] = [
            'range' => [
                'price' => $price
            ]
        ];
    }

    private function setStock(string $count): void
    {
        $count = $this->transformOperator($count);
        $this->searchParams['body']['query']['bool']['filter'][0]['nested']['query']['bool']['must'] = [
            'range' => [
                'stock.stock' => $count
            ]
        ];
    }

    private function transformOperator(string $string): array
    {
        $digit = str_replace(['>', '<'], '', $string);

        if (str_contains($string, '<')) {
            return ['lt' => $digit];
        }

        if (str_contains($string, '>')) {
            return ['gt' => $digit];
        }

        return [];
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(array $commands): Elasticsearch|Promise
    {
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
}
