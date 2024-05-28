<?php

namespace Ahar\Hw16\composite;

class Composite implements Component
{
    private $name;
    private $children = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function add(Component $component)
    {
        $this->children[] = $component;
    }

    public function operation(): string
    {
        $result = "Контейнер {$this->name} содержит:\n";
        foreach ($this->children as $child) {
            $result .= $child->operation();
        }
        return $result;
    }
}
