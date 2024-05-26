<?php

interface Component
{
    public function operation(): string;
}

class ConcreteComponent implements Component
{
    public function operation(): string
    {
        return "Основная операция компонента\n";
    }
}

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

class ConcreteDecorator1 extends Decorator
{
    public function operation(): string
    {
        return "Дополнительная операция 1\n" . parent::operation();
    }
}

class ConcreteDecorator2 extends Decorator
{
    public function operation(): string
    {
        return "Дополнительная операция 2\n" . parent::operation();
    }
}

$component = new ConcreteComponent();
echo "Вызов операции компонента:\n";
echo $component->operation();

echo "\n";

$decorator1 = new ConcreteDecorator1($component);
echo "Вызов операции компонента с декоратором 1:\n";
echo $decorator1->operation();

echo "\n";

$decorator2 = new ConcreteDecorator2($component);
echo "Вызов операции компонента с декоратором 2:\n";
echo $decorator2->operation();

