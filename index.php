<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$app = new AleksandrOrlov\Php2024\Elastic('https://localhost:9200', 'elastic', 'pass1234');

$options = getopt('t:c:p:s:');

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

$search = $app->search($params)['hits'];
$total  = $search['total']['value'];


$table = new LucidFrame\Console\ConsoleTable();
$table->setHeaders(['#', 'title', 'sku', 'category', 'price', 'stocks']);

$stockInline = '';

foreach ($search['hits'] as $key => $hit) {
    $data = $hit['_source'];

    foreach ($data['stock'] as $stock) {
        $stockInline .= "{$stock['shop']} {$stock['stock']} шт.; ";
    }

    $table->addRow([$key, $data['title'], $data['sku'], $data['category'], $data['price'], $stockInline]);

    $stockInline = '';
}

$table->setIndent(4)->display();
