<?php

declare(strict_types=1);


/**
 * @property string $title Название книги.
 * @property string $sku Артикул книги.
 * @property string $category Категория книги.
 * @property float $price Цена книги.
 * @property array $stock Информация о наличии книги в различных магазинах.
 */
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
     * @param string $title Название книги.
     * @param string $sku Артикул книги.
     * @param string $category Категория книги.
     * @param float $price Цена книги.
     * @param array $stock Информация о наличии книги в различных магазинах.
     */
    public function __construct(string $title, string $sku, string $category, float $price, array $stock)
    {
        $this->title = $title;
        $this->sku = $sku;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }
}