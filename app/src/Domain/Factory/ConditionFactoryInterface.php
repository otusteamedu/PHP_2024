<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\Factory;

use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Condition;

interface ConditionFactoryInterface
{
    /**
     * Метод создания condition
     *
     * @param string $name
     * @param int $param
     *
     * @return Condition
     */
    public function create(string $name, int $param): Condition;
}
