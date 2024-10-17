<?php

declare(strict_types=1);

namespace App\Analytics\Repository;

use App\Analytics\Exception\CouldNotDeleteEventException;
use App\Analytics\Exception\CouldNotSaveEventException;
use App\Analytics\Model\Event;
use App\Analytics\Model\EventCondition;

interface EventRepositoryInterface
{
    /**
     * @throws CouldNotSaveEventException
     */
    public function save(Event $event): void;

    /**
     * @throws CouldNotDeleteEventException
     */
    public function clear(): void;

    public function findByConditions(EventCondition ...$conditions): ?Event;
}
