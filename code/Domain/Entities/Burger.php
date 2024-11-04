<?php

declare(strict_types=1);

namespace Domain\Entities;

class Burger extends Product
{
    public function getDescription(): string
    {
        return "Burger with " . implode(", ", array_map(fn($i) => $i->getName(), $this->ingredients));
    }
}
