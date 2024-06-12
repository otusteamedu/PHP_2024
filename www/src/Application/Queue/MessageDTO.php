<?php

declare(strict_types=1);

namespace App\Application\Queue;

class MessageDTO
{
    public function __construct(
        public string $uuid,
        public string $description,
    ) {

    }
}