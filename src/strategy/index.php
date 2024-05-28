<?php

use Ahar\Hw16\strategy\ConcreteStrategyAdd;
use Ahar\Hw16\strategy\ConcreteStrategyMultiply;
use Ahar\Hw16\strategy\Context;

$context = new Context(new ConcreteStrategyAdd());
echo "Сложение: " . $context->executeStrategy(10, 5) . "\n";

$context = new Context(new ConcreteStrategyMultiply());
echo "Умножение: " . $context->executeStrategy(10, 5) . "\n";
