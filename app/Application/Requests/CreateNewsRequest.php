<?php

namespace App\Application\Requests;

readonly class CreateNewsRequest
{
    public function __construct(
        public string $url,
    ) {
    }
}
