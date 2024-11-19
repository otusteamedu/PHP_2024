<?php

declare(strict_types=1);

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\QueueGatewayInterface;
use App\Application\Gateway\QueueGatewayRequest;
use App\Application\Gateway\QueueGatewayResponse;
use Symfony\Component\Messenger\MessageBusInterface;

class RabbitGateway implements QueueGatewayInterface
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function sendTask(QueueGatewayRequest $request): void
    {
        try {
            $this->bus->dispatch($request);
        } catch (\Exception $exception) {
            throw new \Exception("Error sendMessage to RabbitMQ: " . $exception->getMessage());
        }
    }
}
