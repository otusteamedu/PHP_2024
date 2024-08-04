<?php

namespace Ahar\Hw15\src\Application\Dto;

readonly class CreateNewsRequest
{
    public function __construct(
        public string $title,
        public string $description,
    )
    {
    }
}
