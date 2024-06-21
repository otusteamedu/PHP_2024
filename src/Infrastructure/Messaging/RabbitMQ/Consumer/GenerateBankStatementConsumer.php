<?php

declare(strict_types=1);

namespace Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Consumer;

use Alogachev\Homework\Application\Messaging\AsyncHandler\AsyncHandlerInterface;
use Alogachev\Homework\Application\Messaging\Consumer\ConsumerInterface;
use Alogachev\Homework\Application\Messaging\Message\BankStatementRequestedMessage;
use Alogachev\Homework\Infrastructure\Messaging\RabbitMQ\Dictionary\GenerateBankStatementDictionary;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class GenerateBankStatementConsumer implements ConsumerInterface
{
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct(
        string $rabbitHost,
        int $rabbitPort,
        string $rabbitUser,
        string $rabbitPassword,
        private readonly AsyncHandlerInterface $asyncHandler,
    ) {
        $this->connection = new AMQPStreamConnection($rabbitHost, $rabbitPort, $rabbitUser, $rabbitPassword);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(
            GenerateBankStatementDictionary::QUEUE_NAME,
            false,
            true,
            false,
            false
        );
    }

    public function consume(): void
    {
        echo "Waiting for messages. TO exist press CTRL+C" . PHP_EOL;

        $this->channel->basic_consume(
            GenerateBankStatementDictionary::QUEUE_NAME,
            '',
            false,
            true,
            false,
            false,
            function (AMQPMessage $AMQPMessage) {
                echo "Got the message " . $AMQPMessage->body . PHP_EOL;
                $data = json_decode($AMQPMessage->body, true);
                $message = new BankStatementRequestedMessage(
                    $data['clientName'],
                    $data['accountNumber'],
                    $data['startDate'],
                    $data['endDate'],
                );
                $this->asyncHandler->handle($message);
            }
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}
