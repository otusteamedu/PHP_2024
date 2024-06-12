<?php

declare(strict_types=1);

namespace App\Application\ImageGenerator;

readonly class ImageDTO implements \JsonSerializable
{
    public function __construct(
        public string $uuid,
        public string $status,
    )
    {

    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->uuid,
            'status' => $this->status,
        ];
    }
}