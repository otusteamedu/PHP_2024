<?php

declare(strict_types=1);

namespace App\Infrastructure\Async\RabbitMQ;

use App\Infrastructure\Async\RabbitMQ\Publisher;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class RegisterApiRequestPublisher extends Publisher
{
    public static function getExchangeName(): string
    {
        return 'api_request.registered';
    }

    protected function declareExchange(AMQPChannel $channel): AMQPChannel
    {
        $channel->exchange_declare(
            static::getExchangeName(),
            AMQPExchangeType::FANOUT,
            false,
            true,
            false
        );

        return $channel;
    }
}
