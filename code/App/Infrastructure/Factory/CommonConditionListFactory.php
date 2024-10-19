<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Condition;
use App\Domain\Entity\ConditionList;
use App\Domain\Factory\ConditionListFactoryInterface;

class CommonConditionListFactory implements ConditionListFactoryInterface
{
    private array $condition_list;
    public function add(Condition $condition): void
    {
        if (isset($this->condition_list)) {
            throw new \Exception('This param exist');
        }
        $this->condition_list[$condition->getName()->getValue()] = $condition->getParam()->getValue();
    }

    public function getList(): array
    {
        return $this->condition_list;
    }
}