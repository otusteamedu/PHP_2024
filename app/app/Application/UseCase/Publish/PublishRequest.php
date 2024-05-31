<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\UseCase\Publish;

readonly final class PublishRequest
{
    public function __construct(
        public string $message,
        public string $email
    ) {
    }
}
