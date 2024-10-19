<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Event;

interface EventRepositoryInterface
{
    /**
     * @return Event[]
     */
    public function findAll(): iterable;

    public function findById(int $id): ?Event;

    public function save(Event $event): void;

    public function delete(Event $event): void;
}
