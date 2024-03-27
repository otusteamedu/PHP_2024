<?php

declare(strict_types=1);

namespace Hukimato\EsApp;

use LucidFrame\Console\ConsoleTable;

class View
{
    public function render(array $books)
    {
        $table = new ConsoleTable();
        $table->setHeaders(['sku', 'title', 'price', 'category', 'stocks']);
        foreach ($books as $book) {
            $book = $book['_source'];
            $book['stocks'] = '';
            foreach ($book['stock'] as $stock) {
                $book['stocks'] .= $stock['shop'] . ':' . $stock['stock'] . PHP_EOL;
            }
            $table->addRow([$book['sku'], $book['title'], $book['price'], $book['category'], $book['stocks']]);
        }
        $table->display();
    }
}
