<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Domain\Repository;

use SFadeev\Hw12\Domain\Entity\Event;
use SFadeev\Hw12\Domain\Exception\EventNotFoundException;

interface EventRepositoryInterface
{
    /**
     * @param Event $event
     * @return Event
     */
    public function save(Event $event): Event;

    /**
     * @return void
     */
    public function clear(): void;

    /**
     * @return Event[]
     *
     * @throws EventNotFoundException
     */
    public function findAllWithPriorityOrder(): array;
}