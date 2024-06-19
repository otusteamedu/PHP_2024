<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Infrastructure\Async\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Pozys\BankStatement\Application\DTO\BankStatementRequest;

class BankStatementRequestSubscriber extends Subscriber
{
    public static function getQueueName(): string
    {
        return 'bank_statement_request';
    }

    public function processMessage(AMQPMessage $message): void
    {
        try {
            $messageBody = $message->getBody();

            echo 'Processing message: ' . $messageBody . PHP_EOL;

            $decodedMessage = json_decode($messageBody, true);

            $requestDto = new BankStatementRequest(
                $decodedMessage['from'],
                $decodedMessage['to'],
                $decodedMessage['email']
            );

            ($this->handler)($requestDto);

            $message->ack();
            echo 'Processed message' . PHP_EOL;
        } catch (\Throwable $th) {
            $message->nack();
            echo 'Could not process message: ' . $th->getMessage() . PHP_EOL;
        }
    }

    protected function bindQueue(AMQPChannel $channel): AMQPChannel
    {
        $queueName = static::getQueueName();

        $channel->queue_declare($queueName, false, true, false, false);

        $exchange = 'bank_statement.get';

        $channel->exchange_declare($exchange, AMQPExchangeType::FANOUT, false, true, false);

        $channel->queue_bind($queueName, $exchange);

        return $channel;
    }
}
