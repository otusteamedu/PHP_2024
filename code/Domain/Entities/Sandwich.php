<?php

declare(strict_types=1);

namespace Domain\Entities;

class Sandwich extends Product
{
    public function getDescription(): string
    {
        return "Sandwich with " . implode(", ", array_map(fn($i) => $i->getName(), $this->ingredients));
    }
}
