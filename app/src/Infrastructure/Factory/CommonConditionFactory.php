<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Infrastructure\Factory;

use SlavaMakhov\OtusArchitectureApp\Domain\Factory\ConditionFactoryInterface;
use SlavaMakhov\OtusArchitectureApp\Domain\ValueObject\Param;
use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Condition;
use SlavaMakhov\OtusArchitectureApp\Domain\ValueObject\Name;

class CommonConditionFactory implements ConditionFactoryInterface
{
    public function create(string $name, int $param): Condition
    {
        return new Condition(
            new Name($name),
            new Param($param)
        );
    }
}