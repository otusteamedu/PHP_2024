<?php

namespace App\Infrastructure\Factory\Queue\RabbitMQ;

use App\Infrastructure\Service\Queue\RabbitMQ\ExchangeParams;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class ExchangeParamsFactory
{
    public function createDefault(): ExchangeParams
    {
        return new ExchangeParams(
            'Main',
            AMQPExchangeType::FANOUT
        );
    }
}
