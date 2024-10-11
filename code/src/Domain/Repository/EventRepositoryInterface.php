<?php

declare(strict_types=1);

namespace Viking311\Api\Domain\Repository;

use Viking311\Api\Domain\Entity\Event;

interface EventRepositoryInterface
{
    /**
     * @param string $id
     * @return Event|null
     */
    public function getById(string $id): ?Event;

    /**
     * @param Event $item
     * @return void
     */
    public function save(Event $item): void;
}
