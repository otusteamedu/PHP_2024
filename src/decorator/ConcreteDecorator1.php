<?php

namespace Ahar\Hw16\decorator;

class ConcreteDecorator1 extends Decorator
{
    public function operation(): string
    {
        return "Дополнительная операция 1\n" . parent::operation();
    }
}
