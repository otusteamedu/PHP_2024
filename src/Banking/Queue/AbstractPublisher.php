<?php

declare(strict_types=1);

namespace App\Banking\Queue;

use PhpAmqpLib\Message\AMQPMessage;

abstract readonly class AbstractPublisher implements PublisherInterface
{
    public function __construct(
        private ConnectionProvider $connectionProvider,
    ) {}

    public function publish(string $messageBody): void
    {
        $channel = $this->connectionProvider->getChannel();

        $this->connectionProvider->setupChannel($channel, $this->getQueueName(), $this->getExchangeName());

        $messageProperties = [
            'content_type' => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ];

        $message = new AMQPMessage($messageBody, $messageProperties);

        $channel->basic_publish($message, $this->getExchangeName());

        $this->connectionProvider->closeConnection();
    }
}
