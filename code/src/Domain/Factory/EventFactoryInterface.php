<?php

declare(strict_types=1);

namespace Viking311\Api\Domain\Factory;

use DateTimeImmutable;
use InvalidArgumentException;
use Viking311\Api\Domain\Entity\Event;

interface EventFactoryInterface
{
    /**
     * @param string $name
     * @param string $email
     * @param string|DateTimeImmutable $eventDate
     * @param string $address
     * @param int $guest
     * @return Event
     * @throws InvalidArgumentException
     */
    public function create(
        string $name,
        string $email,
        string|DateTimeImmutable $eventDate,
        string $address,
        int $guest
    ): Event;
}
