<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Iterator;

use Otus\Hw16\Domain\Entity\FoodItem;

class IngredientIterator implements \Iterator
{
    private FoodItem $foodItem;
    private array $customIngredients;
    private int $position = 0;

    public function __construct(FoodItem $foodItem, array $customIngredients = [])
    {
        $this->foodItem = $foodItem;
        $this->customIngredients = $customIngredients;
    }

    public function current(): FoodItem
    {
        $this->foodItem = $this->foodItem->withIngredient($this->customIngredients[$this->position]);
        return $this->foodItem;
    }

    public function next(): void
    {
        $this->position++;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->customIngredients[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }
}
