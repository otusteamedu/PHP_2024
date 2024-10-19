<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Entity\ConditionList;
use App\Domain\Entity\Event;
use App\Domain\Factory\EventFactoryInterface;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Priority;

class CommonEventFactory implements EventFactoryInterface
{

    public function create(int $priority, string $name, array $condition_list): Event
    {
        return new Event(
            new Priority($priority),
            new Name($name),
            new ConditionList($condition_list)
        );
    }
}