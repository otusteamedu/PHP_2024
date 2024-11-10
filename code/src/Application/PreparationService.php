<?php

declare(strict_types=1);

namespace Irayu\Hw16\Application;

use Irayu\Hw16\Domain\Dish\DishFactory;
use Irayu\Hw16\Domain\Dish\Dish;
use Irayu\Hw16\Domain\Processes\PreparationStrategy;

class PreparationService implements PreparationStrategy
{
    public function __construct(
        private PreparationStatus $status,
        private PreparationStrategy $strategy,
    ) {
    }

    public function prepare(DishFactory $factory): Dish
    {
        $this->status->triggerEvent(new StatusEvent('Начало приготовления'));
        try {
            $dish = $this->strategy->prepare($factory);
            $this->status->triggerEvent(new StatusEvent('Приготовление завершено'));

            return $dish;
        } catch (\Exception $e) {
            $this->status->triggerEvent(new StatusEvent('Ошибка при приготовлении'));
            throw $e;
        }
    }
}
