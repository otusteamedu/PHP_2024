<?php

namespace VladimirGrinko\Patterns\Factory;

class AfterCooking implements CookingEventInterface
{
    public function trigger(): void
    {
        echo "После готовки: Проверка качества.\n";
    }
}
