<?php

declare(strict_types=1);

namespace Viking311\Queue\Application\UseCase\AddEvent;

readonly class AddEventRequest
{
    /**
     * @param string $name
     * @param string $email
     * @param string $eventDate
     * @param string $address
     * @param int $guest
     */
    public function __construct(
        public string $name,
        public string $email,
        public string $eventDate,
        public string $address,
        public int $guest
    ) {
    }
}
