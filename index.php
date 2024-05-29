<?php

declare(strict_types=1);

use AleksandrOrlov\Php2024\Builder\SelectQueryBuilder;

require_once __DIR__ . '/vendor/autoload.php';

try {
    $queryBuilder = new SelectQueryBuilder();
    $result = $queryBuilder
        ->from('news')
        ->where('url_address', 'https://news.mail.ru/incident/60731785/')
        ->where('date', '2024-04-19 08:37:40')
        ->orderBy('id', 'DESC')
        ->execute();

    foreach ($result as $item) {
        echo $item->url_address . PHP_EOL;
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
