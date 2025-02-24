<?php

declare(strict_types=1);

namespace Otus\Hw16\Application\UseCase;

class OrderFoodItemRequest
{
    public function __construct(
        private string $type,
        private array $customIngredients = []
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCustomIngredients(): array
    {
        return $this->customIngredients;
    }
}
