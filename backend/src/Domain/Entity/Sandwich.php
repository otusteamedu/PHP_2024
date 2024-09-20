<?php

declare(strict_types=1);

namespace App\Domain\Entity;

class Burger implements MealInterface
{
    public function getName(): string
    {
        return 'Burger';
    }

    public function prepare():void {
        echo 'Burger is preparing';
    }
}
