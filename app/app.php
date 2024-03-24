<?php

declare(strict_types=1);

use App\Enums\LogLevelEnum;
use App\Services\Connector;
use App\Services\Logger;
use Elastic\Transport\Exception\TransportException;

require '../vendor/autoload.php';

$client = new Connector('otus-shop');

/**
 * Создание/заполнение индекса
 */
try {
    if (!$client->client->indices()->exists(['index' => 'otus-shop'])->asBool()) {
        $indexParams = require './settings.php';
        $client->createIndex($indexParams);

        $client->bulk('./../books.json');
    }
} catch (TransportException $e) {
    echo $e->getMessage();
    var_dump($e->getTrace());
}

$search = readline('Поиск: ');

/**
 * Пример выборки из условия задачи
 */
$params = [
    'bool' => [
        'must' => [
            ['match' => ['title' => ['query' => $search, 'fuzziness' => 'auto']]],
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

try {
    echo $client->search($params);
} catch (Exception $e) {
    echo $e->getMessage();
    new Logger(LogLevelEnum::ERROR, ['type' => 'search-error', 'message' => $e->getMessage()]);
}
