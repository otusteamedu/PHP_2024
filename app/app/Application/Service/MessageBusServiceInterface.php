<?php

declare(strict_types=1);

namespace Rmulyukov\Hw\Application\Service;

use Rmulyukov\Hw\Application\DTO\Message;
use Rmulyukov\Hw\Application\Consumer\Consumer;

interface MessageBusServiceInterface
{
    public function publish(Message $message): void;
    public function consume(Consumer $listener): void;
}
