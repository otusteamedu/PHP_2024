<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

try {
    $options = getopt('i:t:c:p:s:');

    if (!isset($options['i'])) {
        throw new Exception('Index name not set');
    }

    $elastic = new AleksandrOrlov\Php2024\Elastic(
        'https://localhost:9200',
        'elastic',
        'pass1234'
    );
    $index = AleksandrOrlov\Php2024\IndexFactory::create($options['i'], $elastic->getClient());
    $index->create();
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

$search = $index->search($options)['hits'];
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
