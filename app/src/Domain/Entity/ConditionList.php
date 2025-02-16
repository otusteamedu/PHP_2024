<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\Entity;

class ConditionList
{
    /** @var array */
    private array $conditionList;

    /** @param array $conditionList */
    public function __construct(array $conditionList)
    {
        $this->conditionList = $conditionList;
    }

    /** @return array */
    public function getConditionList(): array
    {
        return $this->conditionList;
    }
}
