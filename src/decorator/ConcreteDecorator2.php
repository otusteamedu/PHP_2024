<?php

namespace Ahar\Hw16\decorator;

class ConcreteDecorator2 extends Decorator
{
    public function operation(): string
    {
        return "Дополнительная операция 2\n" . parent::operation();
    }
}
