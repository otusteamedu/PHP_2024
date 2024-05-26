<?php


interface Strategy
{
    public function doOperation(int $num1, int $num2): int;
}

class ConcreteStrategyAdd implements Strategy
{
    public function doOperation(int $num1, int $num2): int
    {
        return $num1 + $num2;
    }
}

class ConcreteStrategyMultiply implements Strategy
{
    public function doOperation(int $num1, int $num2): int
    {
        return $num1 * $num2;
    }
}

class Context
{
    private $strategy;

    public function __construct(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeStrategy(int $num1, int $num2): int
    {
        return $this->strategy->doOperation($num1, $num2);
    }
}

$context = new Context(new ConcreteStrategyAdd());
echo "Сложение: " . $context->executeStrategy(10, 5) . "\n";

$context = new Context(new ConcreteStrategyMultiply());
echo "Умножение: " . $context->executeStrategy(10, 5) . "\n";
