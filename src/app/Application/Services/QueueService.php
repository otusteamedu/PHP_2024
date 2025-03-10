<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Contracts\QueueDriverInterface;

readonly class QueueService
{
    public function __construct(private QueueDriverInterface $driver)
    {
        //
    }

    public function sendMessage(string $message): void
    {
        $this->driver->sendMessage($message);
    }

    public function receiveMessage(callable $callback): void
    {
        $this->driver->receiveMessage($callback);
    }
}
