<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Domain\Factory;

use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Event;

interface EventFactoryInterface
{
    /**
     * Метод создания Event
     *
     * @param int $priority
     * @param string $name
     * @param array $conditionList
     *
     * @return Event
     */
    public function create(int $priority, string $name, array $conditionList): Event;
}
