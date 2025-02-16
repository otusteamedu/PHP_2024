<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp\Infrastructure\Repository;

use ReflectionProperty;
use SlavaMakhov\OtusArchitectureApp\Domain\Repository\EventRepositoryInterface;
use SlavaMakhov\OtusArchitectureApp\Domain\Entity\Event;

class FileEventRepository implements EventRepositoryInterface
{
    /**
     * @return iterable
     */
    public function findAll(): iterable
    {
        return [];
    }

    /**
     * @param int $id
     *
     * @return Event|null
     */
    public function findById(int $id): ?Event
    {
        return null;
    }

    /**
     * @param Event $event
     *
     * @return void
     */
    public function save(Event $event): void
    {
        $reflectionProperty = new ReflectionProperty(Event::class, 'id');
        $reflectionProperty->setValue($event, 1);
    }

    /**
     * @param Event $event
     *
     * @return void
     */
    public function delete(Event $event): void
    {
    }
}