<?php

declare(strict_types=1);

namespace App\Infrastructure\Async\RabbitMQ;

use App\Application\UseCase\ApiRequest\DTO\RegisterRequest;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class ApiRequestProcessorSubscriber extends Subscriber
{
    public static function getQueueName(): string
    {
        return 'api_request_hanlder';
    }

    public function processMessage(AMQPMessage $message): void
    {
        try {
            $messageBody = $message->getBody();

            $this->logger->info('Processing message: ' . $messageBody);

            $decodedMessage = json_decode($messageBody, true);

            $requestDto = new RegisterRequest(
                $decodedMessage['body'],
                $decodedMessage['id'],
            );

            ($this->handler)($requestDto);

            $message->ack();
            $this->logger->info('Processed message: ' . $messageBody);
        } catch (\Throwable $th) {
            $message->nack();
            $this->logger->error('Could not process message: ' . $th->getMessage());
        }
    }

    protected function bindQueue(AMQPChannel $channel): AMQPChannel
    {
        $queueName = static::getQueueName();

        $channel->queue_declare($queueName, false, true, false, false);

        $exchange = 'api_request.registered';

        $channel->exchange_declare($exchange, AMQPExchangeType::FANOUT, false, true, false);

        $channel->queue_bind($queueName, $exchange);

        return $channel;
    }
}
