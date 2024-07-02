<?php

declare(strict_types=1);


namespace App\Infrastructure\Repository;


use App\Domain\Entity\Book;
use App\Domain\ValueObject\Category;
use App\Domain\ValueObject\Price;
use App\Domain\ValueObject\Sku;
use App\Domain\ValueObject\Stock;
use App\Domain\ValueObject\StockCollection;
use App\Domain\ValueObject\Title;

class BookDataMapper
{
    public function map(array $bookData): Book
    {
        $stockCollection = new StockCollection();
        foreach ($bookData['stock'] as $stockData) {
            $stock = new Stock($stockData['shop'], $stockData['stock']);
            $stockCollection->add($stock);
        }

        return new Book(
            new Title($bookData['title']),
            new Sku($bookData['sku']),
            new Category($bookData['category']),
            new Price($bookData['price']),
            $stockCollection
        );
    }
}
