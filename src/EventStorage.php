<?php

declare(strict_types=1);

namespace Afilipov\Hw12;

interface EventStorage
{
    public function addEvent(Event $event): void;

    /**
     * @psalm-return list<Event>
     * @return array
     */
    public function getEvents(): array;

    public function clearEvents(): void;
}
