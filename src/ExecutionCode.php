<?php

use App\Application\QueryBuilder\EventSubscriber\QueryBuilderSubscriber;
use App\Application\QueryBuilder\Publisher\QueryBuilderPublisher;
use App\Application\QueryBuilder\SelectQueryBuilder;

require_once './../../../../vendor/autoload.php';

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
