<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Infrastructure\Factory;

use SlavaMakhov\OtusArchitectureApp\Domain\Factory\ConditionListFactoryInterface;
use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Condition;

class CommonConditionListFactory implements ConditionListFactoryInterface
{
    /** @var array */
    private array $conditionList;

    /**
     * @param Condition $condition
     * @return void
     *
     * @throws Exception
     */
    public function add(Condition $condition): void
    {
        if (isset($this->conditionList)) {
            throw new \Exception('This param exist');
        }
        $this->conditionList[$condition->getName()->getValue()] = $condition->getParam()->getValue();
    }

    /** @return array */
    public function getList(): array
    {
        return $this->conditionList;
    }
}
