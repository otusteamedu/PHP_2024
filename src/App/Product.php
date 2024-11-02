<?php

namespace Komarov\Hw14\App;

readonly class Product
{
    public function __construct(
        private int $id,
        private string $name,
        private string $description,
        private float $price
    ) {

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
