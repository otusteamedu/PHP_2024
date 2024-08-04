<?php

namespace Ahar\Hw15\src\Application\Dto;

readonly class UpdateNewsRequest
{
    public function __construct(
        public int    $id,
        public string $title,
        public string $description,
    )
    {
    }
}
