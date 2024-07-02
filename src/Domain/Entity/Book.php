<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\StockCollection;
use App\Domain\ValueObject\Category;
use App\Domain\ValueObject\Price;
use App\Domain\ValueObject\Sku;
use App\Domain\ValueObject\Title;

class Book
{
    public $title;
    public $sku;
    public $category;
    public $price;
    public $stock;

    /**
     * Конструктор книги.
     *
     * @param Title $title Название книги.
     * @param Sku $sku Артикул книги.
     * @param Category $category Категория книги.
     * @param Price $price Цена книги.
     * @param StockCollection $stock Информация о наличии книги в различных магазинах.
     */
    public function __construct(Title $title, Sku $sku, Category $category, Price $price, StockCollection $stock)
    {
        $this->title = $title;
        $this->sku = $sku;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }
}
