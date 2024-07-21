<?php

declare(strict_types=1);

namespace App\Domain\Collection;

use App\Domain\ValueObject\Condition;
use ArrayIterator;
use IteratorAggregate;
use Countable;

class ConditionCollection implements IteratorAggregate, Countable
{
    private array $conditions = [];
    public function __construct(Condition ...$conditions)
    {
    }

    public function add(Condition $condition): void
    {
        $this->conditions[] = $condition;
    }

    public function getAll(): array
    {
        return $this->conditions;
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->conditions);
    }
    public function count(): int
    {
        return count($this->conditions);
    }
    public function isEmpty(): bool
    {
        return empty($this->conditions);
    }

    public function toArray(): array
    {
        $conditionArray = [];
        foreach ($this->conditions as $condition) {
            $conditionArray[$condition->getParamName()] = $condition->getParamValue();
        }
        return $conditionArray;
    }
}
