<?php

declare(strict_types=1);

namespace Domain\Entities;

class HotDog extends Product
{
    public function getDescription(): string
    {
        return "HotDog with " . implode(", ", array_map(fn($i) => $i->getName(), $this->ingredients));
    }
}
