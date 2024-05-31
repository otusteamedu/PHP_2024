<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\DTO;

use Stringable;

use function json_encode;

readonly final class Message implements Stringable
{
    public function __construct(
        public string $message,
        public string $email
    ) {
    }

    public function __toString(): string
    {
        return json_encode([
            'message' => $this->message,
            'email' => $this->email
        ]);
    }
}
