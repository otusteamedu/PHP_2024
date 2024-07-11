<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Producer;

use Alogachev\Homework\Application\Messaging\DTO\AMQPQueueDto;
use Alogachev\Homework\Application\Messaging\Message\QueueMessageInterface;
use Alogachev\Homework\Application\Messaging\Producer\ProducerInterface;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Dictionary\GenerateBankStatementDictionary;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\RabbitManagerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class GenerateBankStatementProducer implements ProducerInterface
{
    public function __construct(
        private readonly RabbitManagerInterface $rabbitManager,
    ) {
    }

    public function sendMessage(QueueMessageInterface $message): void
    {
        $channel = $this->rabbitManager->getChannelWithQueueDeclared(
            new AMQPQueueDto(
                GenerateBankStatementDictionary::QUEUE_NAME,
                false,
                true,
                false,
                false,
            )
        );

        $message = new AMQPMessage(json_encode($message->toArray()));
        $channel->basic_publish($message, '', GenerateBankStatementDictionary::QUEUE_NAME);
    }
}
