<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\GetStatus;

/**
 * @OA\Schema
 */
class GetStatusResponse
{
    public function __construct(
        /**
         * @OA\Property
         */
        public ?string $status
    ) {
    }
}
