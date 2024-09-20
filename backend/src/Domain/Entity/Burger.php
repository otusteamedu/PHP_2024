<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Burger implements Meal
{
    public function getName(): string
    {
        return 'Burger';
    }
}
