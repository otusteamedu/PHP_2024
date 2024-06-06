<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Infrastructure\Async\RabbitMQ;

use Pozys\BankStatement\Application\UseCase\MessageBrokerInterface;

class Publisher implements MessageBrokerInterface
{
    public function publish(array $data): void
    {
        // TODO: Implement publish() method.
    }
}
