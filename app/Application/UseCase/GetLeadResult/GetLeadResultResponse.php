<?php

namespace App\Application\UseCase\GetLeadResult;

readonly class GetLeadResultResponse
{
    public function __construct(
        public ?string $result,
    )
    {
    }
}
