<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Condition;
use App\Domain\Entity\ConditionList;

interface ConditionListFactoryInterface
{
    public function add(Condition $condition): void;

    public function getList(): array;
}