<?php

namespace Ahar\Hw16\decorator;

class ConcreteComponent implements Component
{
    public function operation(): string
    {
        return "Основная операция компонента\n";
    }
}
