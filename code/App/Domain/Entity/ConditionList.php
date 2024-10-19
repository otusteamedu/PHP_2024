<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Param;

class ConditionList
{
    private array $condition_list;

    public function __construct(array $condition_list)
    {
        $this->condition_list = $condition_list;
    }

    public function getConditionList(): array
    {
        return $this->condition_list;
    }
}
