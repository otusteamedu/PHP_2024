<?php

declare(strict_types=1);

namespace App\Application\UseCase\DTO;

readonly class SuccessSubscribedDto
{
    public function __construct(
        public string $message,
    ) {
    }
}
