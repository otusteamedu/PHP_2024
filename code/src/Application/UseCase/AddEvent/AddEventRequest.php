<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\AddEvent;

/**
 * @OA\Schema
 */
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
        /**
         * @OA\Property
         */
        public string $name,
        /**
         * @OA\Property
         */
        public string $email,
        /**
         * @OA\Property
         */
        public string $eventDate,
        /**
         * @OA\Property
         */
        public string $address,
        /**
         * @OA\Property
         */
        public int $guest
    ) {
    }
}
