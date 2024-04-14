<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Redis\Repository;

use AlexanderPogorelov\Redis\Entity\Event;
use AlexanderPogorelov\Redis\Exception\SearchCriteriaException;
use AlexanderPogorelov\Redis\Exception\StorageException;
use AlexanderPogorelov\Redis\Search\SearchCriteria;

interface EventRepositoryInterface
{
    /**
     * @throws StorageException
     */
    public function add(Event $event): void;

    /**
     * @throws StorageException
     */
    public function clearAll(): void;

    /**
     * @throws StorageException
     * @throws SearchCriteriaException
     */
    public function findByCriteria(SearchCriteria $criteria): ?Event;

    /**
     * @throws StorageException
     */
    public function getTotal(): int;
}
