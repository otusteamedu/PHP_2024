<?php

declare(strict_types=1);

namespace Ikachko\Hw14\DataMapper;

class Product
{
    public function __construct(
        private int $id,
        private string $title,
        private int $price,
        private int $remnant
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Product
    {
        $this->title = $title;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getRemnant(): int
    {
        return $this->remnant;
    }

    public function setRemnant(int $remnant): Product
    {
        $this->remnant = $remnant;
        return $this;
    }

    public function __toString(): string
    {
        return $this->title . " - price " . $this->price . ", remnant " . $this->remnant;
    }
}
