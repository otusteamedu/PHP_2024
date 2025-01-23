<?php

declare(strict_types=1);

namespace App\UseCase\CreateEmail;

final readonly class CreateEmailRequest
{
    public function __construct(
        public string $from,
        public string $to,
        public string $text,
    ) {}
}
