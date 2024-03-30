<?php

declare(strict_types=1);

namespace App;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class Base
{
    public QueryBuilder $queryBuilder;

    public function __construct()
    {
        $this->queryBuilder = new QueryBuilder();
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException|MissingParameterException
     */
    public function run(): void
    {
        $searchData['search_string'] = readline("Поиск: ");
        $searchData['category'] = readline("Категория: ");
        $searchData['range_price'] = readline("Выберите диапозон цен [>, >=, <, <=]: ");
        $searchData['price'] = readline("Цена: ");

        $response = $this->queryBuilder->queryBuilder($searchData);
        $this->getResult($response);
    }

    public function getResult(array $data): void
    {
        echo "Итого " . count($data['hits']['hits']) . " записей";
        echo PHP_EOL;

        printf('%-15s%-15s%-30s', "sku", "stock", "title");
        echo PHP_EOL;

        foreach ($data['hits']['hits'] as $item) {
            $stock = array_sum(array_column($item['_source']['stock'], 'stock'));
            $title = mb_strimwidth($item['_source']['title'], 0, 30, "...");

            printf('%-15s%-15s%-30s', $item['_source']['sku'], $stock, $title);
            echo PHP_EOL;;
        }
    }
}
