<?php

declare(strict_types=1);

namespace App\Shop\Transformer;

use App\Shop\Model\Book;

final readonly class BookTransformer
{
    public function toTable(Book ...$books): array
    {
        $rows = array_map(function (Book $book) {
            return [
                $book->title,
                $book->sku,
                $book->category,
                $book->price,
                $book->getTotalStockCount(),
            ];
        }, $books);

        return [
            'headers' => [
                'Title',
                'SKU',
                'Category',
                'Price',
                'Stock Count'
            ],
            'rows' => $rows
        ];
    }
}