<?php

declare(strict_types=1);

namespace Irayu\Hw16\Presentation;

use Irayu\Hw16\Application\PreparationStatus;
use Irayu\Hw16\Application\StatusEvent;
use Irayu\Hw16\Domain\Processes\PreparationStrategy;
use Irayu\Hw16\Domain\Dish\DishFactory;
use Irayu\Hw16\Domain\Dish\Dish;

class Restaurant
{
    public function __construct(
        private PreparationStatus $status,
        private PreparationStrategy $strategy,
    ) {
    }

    public function serve(DishFactory $factory, array $addOnes = []): Dish
    {
        $this->status->triggerEvent(new StatusEvent('Начало приготовления'));
        $dish = $this->strategy->prepare($factory);
        foreach ($addOnes as $addOn) {
            $dish = new $addOn($dish);
        }
        $this->status->triggerEvent(new StatusEvent('Приготовление завершено'));

        return $dish;
    }
}
