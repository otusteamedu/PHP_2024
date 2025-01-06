<?php

declare(strict_types=1);

namespace Amikha1lov\DataMapper\Entities;

use Amikha1lov\DataMapper\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Product implements Entity
{
    public function __construct(
        private int $id,
        #[Assert\NotBlank]
        private string $name,
        #[Assert\Positive]
        private float $price,
    ) {
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
