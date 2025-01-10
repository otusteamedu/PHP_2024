<?php

declare(strict_types=1);

namespace Ikachko\Hw14\DataMapper;

use Iterator;

class ProductCollection implements Iterator
{
    private int $pointer = 0;
    private array $products = [];

    public function __construct(array $rawItems = [], ProductMapper $productMapper = null)
    {
        if (empty($rawItems) || empty($productMapper)) {
            return;
        }

        foreach ($rawItems as $arProduct) {
            $product = $productMapper->createObject($arProduct);
            $this->addProduct($product);
        }
    }

    public function addProduct(Product $product): void
    {
        if (!in_array($product, $this->products)) {
            $this->products[] = $product;
        }
    }

    public function removeProduct(Product $product): void
    {
        if (!in_array($product, $this->products)) {
            return;
        }

        foreach ($this->products as $key => $item) {
            if ($item == $product) {
                unset($this->products[$key]);
                $this->products = array_values($this->products);
                return;
            }
        }
    }

    public function current(): mixed
    {
        return $this->products[$this->pointer] ?? null;
    }

    public function next(): void
    {
        if (isset($this->products[$this->pointer])) {
            $this->pointer++;
        }
    }

    public function key(): mixed
    {
        return $this->pointer;
    }

    public function valid(): bool
    {
        return isset($this->products[$this->pointer]);
    }

    public function rewind(): void
    {
        $this->pointer = 0;
    }
}
