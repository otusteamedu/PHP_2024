<?php

declare(strict_types=1);

namespace AlexanderGladkov\Analytics\Repository;

use AlexanderGladkov\Analytics\Entity\Event;

interface EventRepositoryInterface
{
    /**
     * @param Event $event
     * @return void
     * @throws EventRepositoryException
     */
    public function add(Event $event): void;

    /**
     * @return void
     * @throws EventRepositoryException
     */
    public function deleteAll(): void;

    /**
     * @param array $conditions
     * @return Event|null
     * @throws EventRepositoryException
     */
    public function find(array $conditions): ?Event;
}
