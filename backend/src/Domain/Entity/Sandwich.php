<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Sandwich implements Meal
{
    public function getName(): string
    {
        return 'Sandwich';
    }
}
