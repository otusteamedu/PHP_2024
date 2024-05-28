<?php

namespace Ahar\Hw16\composite;

class Leaf implements Component
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function operation(): string
    {
        return "Листовой узел {$this->name}\n";
    }
}
