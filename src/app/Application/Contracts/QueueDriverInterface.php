<?php

namespace App\Application\Contracts;

interface QueueDriverInterface
{
    public function sendMessage(string $message): void;

    public function receiveMessage(callable $callback): void;
}
