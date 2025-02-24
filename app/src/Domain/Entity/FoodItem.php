<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Entity;

class FoodItem
{
    private ?int $id;
    private string $type;
    private array $ingredients;

    public function __construct(string $type, array $ingredients = [], ?int $id = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->ingredients = $ingredients;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function withIngredient(string $ingredient): self
    {
        $newIngredients = array_merge($this->ingredients, [$ingredient]);
        return new self($this->type, $newIngredients, $this->id);
    }
}
