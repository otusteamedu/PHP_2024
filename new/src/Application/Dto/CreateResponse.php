<?php

namespace Ahar\Hw15\src\Application\Dto;

readonly class CreateResponse
{
    public function __construct(
        public int     $responseCode,
        public ?string $errorMessage = ''
    )
    {
    }
}
