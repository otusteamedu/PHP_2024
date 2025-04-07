<?php

declare(strict_types=1);

namespace Irayu\Hw16\Infrastructure;

use Irayu\Hw16\Domain;
use Irayu\Hw16\Domain\Dish\DishFactory;
use Irayu\Hw16\Domain\Exception\DishException;

class PreparationProcessProxy implements Domain\Processes\PreparationStrategy
{
    public function __construct(private Domain\Processes\PreparationStrategy $preparationProcess)
    {
    }

    public function prepare(DishFactory $factory): Domain\Dish\Dish
    {
        echo "Проверка качества перед приготовлением...\n";
        $dish = $this->preparationProcess->prepare($factory);
        echo "Проверка качества после приготовления...\n";

        if ($this->checkQuality($dish)) {
            return new Dish\Decorator\QualityDecorator($dish);
        }
        $this->discardProduct($dish);
    }

    private function checkQuality(Domain\Dish\Dish $dish): bool
    {
        // Наш фастфуд заведомо качественный
        return true;
    }

    private function discardProduct(Domain\Dish\Dish $dish): void
    {
        throw new DishException("Продукт не прошел проверку качества");
    }
}
