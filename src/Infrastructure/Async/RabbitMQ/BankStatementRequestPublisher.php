<?php

declare(strict_types=1);

namespace Pozys\BankStatement\Infrastructure\Async\RabbitMQ;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class BankStatementRequestPublisher extends Publisher
{
    public static function getExchangeName(): string
    {
        return 'bank_statement.get';
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
