<?php

namespace Otus\Hw16\Application\Command;

use Otus\Hw16\Domain\Entity\FoodItem;
use Otus\Hw16\Domain\Observer\CookingStatusObserverInterface;

class CookFoodItemCommand
{
    public function __construct(
        private FoodItem $foodItem,
        private array $customIngredients = [],
        private CookingStatusObserverInterface $observer
    ) {
    }

    public function getFoodItem(): FoodItem
    {
        return $this->foodItem;
    }

    public function getCustomIngredients(): array
    {
        return $this->customIngredients;
    }

    public function getObserver(): CookingStatusObserverInterface
    {
        return $this->observer;
    }
}
