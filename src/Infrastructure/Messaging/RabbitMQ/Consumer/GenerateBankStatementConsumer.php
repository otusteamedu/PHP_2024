<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Consumer;

use Alogachev\Homework\Application\Messaging\AsyncHandler\AsyncHandlerInterface;
use Alogachev\Homework\Application\Messaging\Consumer\ConsumerInterface;
use Alogachev\Homework\Application\Messaging\DTO\AMQPQueueDto;
use Alogachev\Homework\Application\Messaging\Message\BankStatementRequestedMessage;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Dictionary\GenerateBankStatementDictionary;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\RabbitManagerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class GenerateBankStatementConsumer implements ConsumerInterface
{
    public function __construct(
        private readonly RabbitManagerInterface $rabbitManager,
        private readonly AsyncHandlerInterface $asyncHandler,
    ) {
    }

    public function consume(): void
    {
        echo "Waiting for messages. To exist press CTRL+C" . PHP_EOL;

        $channel = $this->rabbitManager->getChannelWithQueueDeclared(
            new AMQPQueueDto(
                GenerateBankStatementDictionary::QUEUE_NAME,
                false,
                true,
                false,
                false,
            )
        );

        $channel->basic_consume(
            GenerateBankStatementDictionary::QUEUE_NAME,
            '',
            false,
            true,
            false,
            false,
            function (AMQPMessage $AMQPMessage) {
                echo "Got the message " . $AMQPMessage->body . PHP_EOL;
                $data = json_decode($AMQPMessage->body, true);
                $message = new BankStatementRequestedMessage($data['id']);
                $this->asyncHandler->handle($message);
            }
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}
