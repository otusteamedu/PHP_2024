<?php

declare(strict_types=1);

namespace Viking311\Api\Application\UseCase\GetStatus;

class GetStausResponse
{
    public function __construct(public ?string $status)
    {
    }
}
