<?php

declare(strict_types=1);

namespace App;

use App\Services\ElasticService\DbWorker;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Exception;

class Base
{
    public string $index;
    public DbWorker $client;

    public function __construct()
    {
        $this->index = 'otus-shop';
        $this->client = new DbWorker();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException|MissingParameterException
     */
    public function run(): void
    {
        if(!$this->client->isIndex($this->index)) {
            $data = dirname(__FILE__, 3) . "/books.json";
            $this->client->createIndex($this->index);
            $this->client->bulk($data);
        }

        $searchData = readline("Поиск: ");

        $params = [
            'bool' => [
                'must' => [
                    ['match' => ['title' => ['query' => $searchData, 'fuzziness' => 'auto']]],
                    ['term' => ['category.keyword' => 'Исторический роман']]
                ],
                'filter' => [
                    ['range' => ['stock.stock' => ['gte' => 0]]],
                    [
                        'range' => ['price' => ['lt' => 2000]],
                    ],
                ]
            ]
        ];

        $result = $this->client->getDocbyParams($this->index, $params);
        $this->getResult($result);
    }

    public function getResult(array $data): void
    {
        printf('%-15s%-15s%-30s', "sku", "stock", "title");
        echo PHP_EOL;

        foreach ($data['hits']['hits'] as $item) {
            $stock = array_sum(array_column($item['_source']['stock'], 'stock'));
            $title = mb_strimwidth($item['_source']['title'], 0, 30, "...");

            printf('%-15s%-15s%-30s', $item['_source']['sku'], $stock, $title );
            echo PHP_EOL;;
        }
    }
}
