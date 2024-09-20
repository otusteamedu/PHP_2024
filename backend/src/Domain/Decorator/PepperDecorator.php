<?php

declare(strict_types=1);

namespace App\Domain\Decorator;

class PepperDecorator extends MealDecorator
{
    public function getName(): string
    {
        return $this->meal->getName() . " with peper";
    }

    public function prepare(): void
    {
        parent::prepare();

        $this->addOnion();
    }

    private function addOnion(): void
    {
        echo "Добавляем перец.\n";
    }
}
