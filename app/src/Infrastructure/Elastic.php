<?php

declare(strict_types=1);

namespace Kagirova\Hw14\Infrastructure;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Http\Client\Exception;
use Kagirova\Hw14\Domain\Entity\Book;
use Kagirova\Hw14\Domain\Repository\RepositoryInterface;

class Elastic implements RepositoryInterface
{
    private Client $client;
    private const INDEX_NAME = 'otus-shop';

    public function __construct(private string $host, private string $user, private string $password)
    {
        $this->connect();
        if (!$this->client->indices()->exists(['index' => Elastic::INDEX_NAME])) {
            $this->createIndex();
            $this->fillData('../files/books.json');
        }
    }

    private function connect()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$this->host])
            ->setBasicAuthentication($this->user, $this->password)
            ->build();
    }

    private function createIndex()
    {
        $indexParams = file_get_contents('../files/index.json');
        $this->client->indices()->create(json_decode($indexParams, true));
    }

    private function fillData($fileName)
    {
        $body = file_get_contents($fileName);
        try {
            $this->client->bulk([
                'body' => $body
            ]);
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function search($params)
    {
        $query = [
            'index' => Elastic::INDEX_NAME,
            'body' => [
                'sort' => ['_score' => 'desc'],
                'query' => [
                    'bool' => [
                        'must' => [
                        ]
                    ]
                ]
            ]
        ];

        foreach ($params as $key => $value) {
            $paramQuery = match ($key) {
                "title" => $this->matchTitleQuery($value),
                "category" => $this->matchCategoryQuery($value),
                "instock" => $this->inStockQuery($value),
                "price_lesser_than" => $this->priceQuery($value, false),
                "price_greater_than" => $this->priceQuery($value, true)
            };
            array_push($query['body']['query']['bool']['must'], $paramQuery);
        }
        $response = $this->client->search($query);

        $bookArray = [];
        foreach ($response['hits']['hits'] as $productData) {
            $id = (int)preg_replace('/[^0-9]/', '', $productData['_id']);
            $title = $productData['_source']['title'];
            $category = $productData['_source']['category'];
            $price = $productData['_source']['price'];
            $stock = '';
            foreach ($productData['_source']['stock'] as $stockData) {
                $stock .= $stockData['shop'] . ': ' . $stockData['stock'] . ' ';
            }
            $product = new Book($id, $title, $category, $price, $stock);
            array_push($bookArray, $product);
        }
        return $bookArray;
    }

    private function matchTitleQuery(string $value)
    {
        return [
            'match' => [
                "title" => [
                    "query" => $value,
                    'fuzziness' => 1
                ]
            ]
        ];
    }

    private function matchCategoryQuery(string $value)
    {
        return [
            'match' => [
                "category" => [
                    "query" => $value,
                    'fuzziness' => 1
                ]
            ]
        ];
    }

    private function inStockQuery(string $value)
    {
        $nestedArray = [
            "nested" => [
                "path" => "stock",
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                'match' => [
                                    "stock.shop" => $value
                                ]
                            ],
                            [
                                "range" => [
                                    "stock.stock" => [
                                        "gte" => 0
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return $nestedArray;
    }

    private function priceQuery(string $value, bool $isGreater)
    {
        $operation = 'lt';
        if ($isGreater) {
            $operation = 'gt';
        }
        return [
            'range' => [
                "price" => [
                    $operation => $value
                ]
            ]
        ];
    }
}
