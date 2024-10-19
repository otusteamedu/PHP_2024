<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Event;
use App\Domain\Repository\EventRepositoryInterface;

class FileEventRepository implements EventRepositoryInterface
{

    public function findAll(): iterable
    {
        // TODO: Implement findAll() method.
        return [];
    }

    public function findById(int $id): ?Event
    {
        // TODO: Implement findById() method.
        return null;
    }

    public function save(Event $event): void
    {
        // Имитация сохранения в БД с присваиванием ID
        $reflectionProperty = new \ReflectionProperty(Event::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($event, 1);
    }

    public function delete(Event $event): void
    {
        // TODO: Implement delete() method.
    }
}