<?php

namespace App\Application\UseCase\GetLeadStatus;

readonly class GetLeadStatusResponse
{
    public function __construct(
        public string $status,
    )
    {
    }
}
