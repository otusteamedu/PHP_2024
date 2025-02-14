<?php

declare(strict_types=1);

namespace App\Application\Messaging;

interface MessageSenderInterface
{
    public function send(string $queue, array $message, string $exchange, string $routingKey): void;
}