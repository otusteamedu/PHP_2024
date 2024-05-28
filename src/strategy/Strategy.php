<?php

namespace Ahar\Hw16\strategy;

interface Strategy
{
    public function doOperation(int $num1, int $num2): int;
}
