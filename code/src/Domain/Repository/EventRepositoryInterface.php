<?php

declare(strict_types=1);

namespace IraYu\Hw12\Domain\Repository;

use IraYu\Hw12\Domain\Entity\Event;
use IraYu\Hw12\Domain\Entity\EventProperty;

interface EventRepositoryInterface
{
    public function save(Event $event): Event;

    public function clear(): void;

    /**
     * @param EventProperty[] $properties
     * @return array
     */
    public function findByProperties(array $properties): array;
}
