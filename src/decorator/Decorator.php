<?php

namespace Ahar\Hw16\decorator;

abstract class Decorator implements Component
{
    protected $component;

    public function __construct(Component $component)
    {
        $this->component = $component;
    }

    public function operation(): string
    {
        return $this->component->operation();
    }
}
