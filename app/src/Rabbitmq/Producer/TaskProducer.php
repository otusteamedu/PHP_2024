<?php

declare(strict_types=1);

namespace App\Rabbitmq\Producer;

use App\Rabbitmq\Message\TaskMessage;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class TaskProducer
{
    public function __construct(
        private readonly ProducerInterface $producer,
    ) {
    }

    /**
     * @throws \JsonException
     */
    public function publish(TaskMessage $message): void
    {
        $json = json_encode($message, JSON_THROW_ON_ERROR);
        $this->producer->publish($json);
    }
}
