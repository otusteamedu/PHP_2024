<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Entity\Condition;
use App\Domain\Entity\Event;
use App\Domain\Factory\ConditionFactoryInterface;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Param;

class CommonConditionFactory implements ConditionFactoryInterface
{

    public function create(string $name, int $param): Condition
    {
        return new Condition(
            new Name($name),
            new Param($param),
        );
    }
}