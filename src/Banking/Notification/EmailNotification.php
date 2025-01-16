<?php

declare(strict_types=1);

namespace App\Banking\Notification;

final readonly class EmailNotification implements NotificationInterface
{
    public function __construct(
        public string $from,
        public string $to,
        public string $body,
    ) {}

    public function toArray(): array
    {
        return [
            'from' => $this->from,
            'to' => $this->to,
            'body' => $this->body,
        ];
    }
}
