<?php

declare(strict_types=1);

namespace App\Application\DTO;

readonly class ImageDTO
{
    public function __construct(
        public string $uuid,
        public string $description,
        public ?string $path,
    ) {
    }
}
