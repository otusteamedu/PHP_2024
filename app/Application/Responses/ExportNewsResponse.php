<?php

namespace App\Application\Responses;

readonly class ExportNewsResponse
{
    public function __construct(
        public string $url,
    ) {}
}
