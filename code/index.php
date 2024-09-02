<?php

declare(strict_types=1);

use Viking311\Builder\SelectBuilder\SelectBuilderFactory;

require 'vendor/autoload.php';

$factory = new SelectBuilderFactory();

echo "Немедленное выполнение запроса<br />";
$builder = $factory->getSelectBuilder();
$result = $builder
    ->from('test')
    ->orderBy('id', 'desc')
    ->where('id', '2')
    ->execute();

foreach($result as $item) {
    var_dump($item);
}


echo "Отложенное выполнение запроса<br />";
$lazyBuilder = $factory->getLazySelectBuilder();
$result = $lazyBuilder
    ->from('test')
    ->orderBy('id', 'desc')
    ->execute();

foreach($result as $item) {
    var_dump($item);
}
