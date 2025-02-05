<?php

namespace App\Domain\DTO\Bus;

class ChatUpdateDTO
{
    public function __construct(
        public readonly string $data,
    ) {
    }
}
