<?php

namespace App\Application\Responses;

readonly class CreateNewsResponse
{
    public function __construct(
        public int $id,
    ) {}
}
