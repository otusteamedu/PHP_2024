<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Chain;

use Otus\Hw16\Domain\Entity\FoodItem;

class BurgerHandler implements CookingHandlerInterface
{
    private ?CookingHandlerInterface $nextHandler = null;

    public function setNext(CookingHandlerInterface $handler): self
    {
        $this->nextHandler = $handler;
        return $this;
    }

    public function handle(FoodItem $foodItem): void
    {
        if ($foodItem->getType() === 'burger') {
            // Логика приготовления бургера
        } elseif ($this->nextHandler) {
            $this->nextHandler->handle($foodItem);
        }
    }
}
