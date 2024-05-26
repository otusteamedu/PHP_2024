<?php

interface Component
{
    public function operation(): string;
}

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

function clientCode(Component $component)
{
    echo $component->operation();
}

// Пример использования
$leaf1 = new Leaf("Лист 1");
$leaf2 = new Leaf("Лист 2");
$composite = new Composite("Контейнер 1");

$composite->add($leaf1);
$composite->add($leaf2);

clientCode($composite);
