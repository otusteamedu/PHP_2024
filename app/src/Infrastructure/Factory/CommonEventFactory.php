<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Infrastructure\Factory;

use SlavaMakhov\OtusArchitectureApp\Domain\Factory\EventFactoryInterface;
use SlavaMakhov\OtusArchitectureApp\Domain\Entity\ConditionList;
use SlavaMakhov\OtusArchitectureApp\Domain\ValueObject\Priority;
use SlavaMakhov\OtusArchitectureApp\Domain\ValueObject\Name;
use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Event;

class CommonEventFactory implements EventFactoryInterface
{
    /**
     * @param int $priority
     * @param string $name
     * @param array $conditionList
     *
     * @return Event
     */
    public function create(int $priority, string $name, array $conditionList): Event
    {
        return new Event(
            new Priority($priority),
            new Name($name),
            new ConditionList($conditionList)
        );
    }
}
