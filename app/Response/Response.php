<?php

declare(strict_types=1);

namespace App\Response;

class Response
{
    public function __construct(
        public readonly string $content,
    ) {
    }
}
