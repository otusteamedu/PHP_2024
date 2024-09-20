<?php

declare(strict_types=1);

namespace App\Domain\Decorator;

class LettuceDecorator extends MealDecorator
{
    public function getName(): string
    {
        return $this->meal->getName() . " с салатом";
    }

    public function prepare(): void
    {
        parent::prepare();

        $this->addOnion();
    }

    private function addOnion(): void
    {
        echo "Добавляем салат.\n";
    }

}