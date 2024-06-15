<?php

declare(strict_types=1);

namespace Afilipov\Hw16\proxy;

readonly class FoodProxy implements IFood
{
    public function __construct(private IFood $foodItem)
    {
    }

    public function cook(): void
    {
        $this->beforeCooking();
        $this->foodItem->cook();
        $this->afterCooking();
    }

    private function beforeCooking(): void
    {
        echo "Подготовка к готовке\n";
    }

    private function afterCooking(): void
    {
        echo "Проверка продукта на соответствие стандартам\n";
    }
}
