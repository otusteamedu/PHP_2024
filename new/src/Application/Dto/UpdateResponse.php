<?php

namespace Ahar\hw15\src\Application\Dto;

readonly class UpdateResponse
{
    public function __construct(
        public int     $responseCode,
        public ?string $errorMessage = ''
    )
    {
    }
}
