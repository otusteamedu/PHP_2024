<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\GetStatus;

use OpenApi\Attributes as OA;

#[OA\Schema]
class GetStatusResponse
{
    public function __construct(
        #[OA\Property]
        public ?string $status
    ) {
    }
}
