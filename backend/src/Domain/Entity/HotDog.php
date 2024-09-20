<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class HotDog implements Meal
{
    public function getName(): string
    {
        return 'Hot dog';
    }
}
