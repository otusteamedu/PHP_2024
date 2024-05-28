<?php

use Ahar\Hw16\composite\Composite;
use Ahar\Hw16\composite\Leaf;

function client_code(Component $component)
{
    echo $component->operation();
}

// Пример использования
$leaf1 = new Leaf("Лист 1");
$leaf2 = new Leaf("Лист 2");
$composite = new Composite("Контейнер 1");

$composite->add($leaf1);
$composite->add($leaf2);

client_code($composite);
