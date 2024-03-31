<?php

declare(strict_types=1);

namespace Alogachev\Homework\Elk;

use Elastic\Elasticsearch\Response\Elasticsearch;

class ElkConsoleView
{
    public function render(Elasticsearch $data): void
    {
        if (empty($data['hits']['hits'])) {
            echo '====================================================================' . PHP_EOL;
            echo 'Не удалось ничего найти' . PHP_EOL;
        }
        echo '====================================================================' . PHP_EOL;

        foreach ($data['hits']['hits'] as $book) {
            echo 'Код: ' . $book['_source']['sku'] . PHP_EOL;
            echo 'Наименование: ' . $book['_source']['title'] . PHP_EOL;
            echo 'Категория: ' . $book['_source']['category'] . PHP_EOL;
            echo 'Цена: ' . $book['_source']['price'] . PHP_EOL;
            echo 'В наличие: ' . PHP_EOL;
            foreach ($book['_source']['stock'] as $shop) {
                echo 'Магазин: ' . $shop['shop'] . PHP_EOL;
                echo 'Количество: ' . $shop['stock'] . PHP_EOL;
            }
            echo '====================================================================' . PHP_EOL;
        }
    }
}
