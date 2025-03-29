<?php

declare(strict_types=1);

namespace Aware\App\Domain\Event;

use Aware\App\Infrastructure\Event\EventRedisRepository;

interface EventRepositoryInterface
{
    public function addEvent(Event $event): void;

    public function getBestEvent(array $conditions): Event;

    public function deleteEvents(): void;

    public function migrate(EventRedisRepository $eventRepository): void;
}
