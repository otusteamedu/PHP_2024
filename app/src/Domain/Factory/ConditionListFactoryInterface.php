<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\Factory;

use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Condition;

interface ConditionListFactoryInterface
{
    /**
     * Метод добаваления condition
     *
     * @param Condition $condition
     *
     * @return void
     */
    public function add(Condition $condition): void;

    /**
     * Метод получения списка condition
     *
     * @return array
     */
    public function getList(): array;
}
