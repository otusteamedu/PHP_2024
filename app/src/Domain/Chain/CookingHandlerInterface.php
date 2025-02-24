<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Chain;

use Otus\Hw16\Domain\Entity\FoodItem;

interface CookingHandlerInterface
{
    public function setNext(CookingHandlerInterface $handler): self;
    public function handle(FoodItem $foodItem): void;
}
