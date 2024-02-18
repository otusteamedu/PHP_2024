<?php

declare(strict_types=1);

namespace Rmulyukov\Hw5\Chat;

final readonly class Message
{
    public function __construct(
        private string $from,
        private string $to,
        private string $message,
        private int $length
    ) {
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getLength(): int
    {
        return $this->length;
    }
}
