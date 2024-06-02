<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Event;
use App\Domain\Exception\DomainException;
use App\Domain\Exception\NotFoundException;

interface EventRepositoryInterface
{
    /**
     * @throws DomainException
     */
    public function save(Event $event): void;

    /**
     * @throws DomainException
     */
    public function deleteAll(): void;

    /**
     * @return Event|null
     * @throws DomainException|NotFoundException
     */
    public function matchByCondition(array $condition): ?Event;
}
