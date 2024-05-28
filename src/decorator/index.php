<?php

use Ahar\Hw16\decorator\ConcreteComponent;
use Ahar\Hw16\decorator\ConcreteDecorator1;
use Ahar\Hw16\decorator\ConcreteDecorator2;

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
