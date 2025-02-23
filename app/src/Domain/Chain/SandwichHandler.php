<?php

namespace Otus\Hw16\Domain\Chain;

use Otus\Hw16\Domain\Entity\FoodItem;

class SandwichHandler implements CookingHandlerInterface
{
    private ?CookingHandlerInterface $nextHandler = null;

    public function setNext(CookingHandlerInterface $handler): self
    {
        $this->nextHandler = $handler;
        return $this;
    }

    public function handle(FoodItem $foodItem): void
    {
        if ($foodItem->getType() === 'sandwich') {
            // Логика приготовления сэндвича
        } elseif ($this->nextHandler) {
            $this->nextHandler->handle($foodItem);
        }
    }
}
