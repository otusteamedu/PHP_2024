<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\GetStatus;

class GetStatusRequest
{
    /**
     * @param string $id
     */
    public function __construct(
        public string $id
    ) {
    }
}
