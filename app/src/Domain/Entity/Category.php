<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Entity;

class Category
{
    public function __construct(
        private int $id,
        private string $name
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
