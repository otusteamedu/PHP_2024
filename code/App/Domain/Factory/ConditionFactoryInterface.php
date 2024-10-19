<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Condition;

interface ConditionFactoryInterface
{
    public function create(string $name, int $param): Condition;
}