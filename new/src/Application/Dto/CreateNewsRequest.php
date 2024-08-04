<?php

namespace Ahar\hw15\src\Application\Dto;

readonly class CreateNewsRequest
{
    public function __construct(
        public string $title,
        public string $description,
    )
    {
    }
}
