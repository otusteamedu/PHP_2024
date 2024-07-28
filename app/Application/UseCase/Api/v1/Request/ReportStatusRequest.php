<?php

namespace App\Application\UseCase\Api\v1\Request;

final readonly class ReportStatusRequest
{
    public function __construct(
        public ?string $uid
    )
    {
    }
}
