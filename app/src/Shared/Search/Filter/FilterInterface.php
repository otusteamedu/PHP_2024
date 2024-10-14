<?php

declare(strict_types=1);

namespace App\Shared\Search\Filter;

interface FilterInterface
{
    public function getField(): string;

    public function getCondition(): string | array;

    public function getValue(): string;
}
