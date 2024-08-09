<?php

namespace App\DTO;

readonly class Hit
{
    public string $index;
    public string $id;
    public float $score;
    public string $title;
    public string $sku;
    public string $category;
    public int $price;
    public array $stock;

    public function __construct(
        string $index,
        string $id,
        float $score,
        string $title,
        string $sku,
        string $category,
        int $price,
        array $stock
    ) {
        $this->index = $index;
        $this->id = $id;
        $this->score = $score;
        $this->title = $title;
        $this->sku = $sku;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }
}
