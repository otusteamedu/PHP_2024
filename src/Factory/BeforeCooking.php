<?php

namespace VladimirGrinko\Patterns\Factory;

class BeforeCooking implements CookingEventInterface
{
    public function trigger(): void
    {
        echo "Перед готовкой: Проверка ингредиентов.\n";
    }
}
