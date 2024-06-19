<?php

declare(strict_types=1);

namespace App\Requests;

class RenderRequest
{
    public function __construct(
        public string $path,
        public string $name,
        public int $size,
        public string $extension,
    ) {
    }
}
