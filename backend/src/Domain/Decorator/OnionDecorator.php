<?php

declare(strict_types=1);

namespace App\Domain\Decorator;

class OnionDecorator extends MealDecorator
{
    public function getName(): string
    {
        return $this->meal->getName() . " with onion";
    }

    public function prepare(): void
    {
        parent::prepare();

        $this->addOnion();
    }

    private function addOnion(): void
    {
        echo "Добавляем лук.\n";
    }
}
