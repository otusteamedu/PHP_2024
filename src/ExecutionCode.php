<?php

use App\Application\QueryBuilder\EventSubscriber\QueryBuilderSubscriber;
use App\Application\QueryBuilder\Publisher\QueryBuilderPublisher;
use App\Application\QueryBuilder\SelectQueryBuilder;

require_once './../../../../vendor/autoload.php';

/* Вариант 1: из кода*/
$publisher = new QueryBuilderPublisher();
$publisher->subscribe(new QueryBuilderSubscriber());

$queryBuilder = new SelectQueryBuilder($publisher);
$result       = $queryBuilder
    ->from('product')
    ->where('category', 'Вино')
    ->where('price', 5000, '>')
    ->orderBy('price')
    ->limit(3)
    ->execute();

function iterate($result)
{
    foreach ($result as $product) {
        echo $product->title . PHP_EOL;
    }
}
iterate($result);

/* Вариант-2: через UseCase */
$request = new SelectQueryRequest(
    'product',
    [
        new WhereDTO('category', 'Вино', null),
        new WhereDTO('price', '5000', '>')
    ],
    'price',
    null,
    3,
    null,
    false
);
$response = (new SelectQueryUseCase())($request);

$result = $response->queryResult;

function iterate($result)
{
    foreach ($result as $product) {
        echo $product->title . PHP_EOL;
    }
}
iterate($result);
