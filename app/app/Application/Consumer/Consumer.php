<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\Consumer;

use Rmulyukov\Hw\Application\DTO\Message;

final readonly class Consumer
{
    public function __construct(
        public string $queue
    ) {
    }

    public function handle(Message $message): void
    {
        \var_dump($message);
    }
}
