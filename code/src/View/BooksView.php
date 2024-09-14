<?php

declare(strict_types=1);

namespace IraYu\Hw11\View;

use PHPYurta\CLI\CLITable;

class BooksView
{
    public function __invoke(array $books): void
    {
        $table = new CLITable();
        $table->setHeaders(['Title', 'Price', 'Category', 'Stocks']);
        foreach ($books as $book) {
            $book = $book['_source'];
            $book['stocks'] = array_map(fn($stock) => $stock['shop'] . ':' . $stock['stock'], $book['stock']);
            $table->addRow([$book['title'], $book['price'], $book['category'], implode('; ', $book['stocks'])]);
        }
        $table->printOut();
    }
}
