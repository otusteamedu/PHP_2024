<?php

namespace VladimirGrinko\Patterns\Factory;

class DisposalEvent implements CookingEventInterface
{
    public function trigger(): void
    {
        echo "Утилизация: Продукт не соответствует стандарту.\n";
    }
}
