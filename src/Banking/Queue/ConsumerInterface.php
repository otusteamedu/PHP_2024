<?php

declare(strict_types=1);

namespace App\Banking\Queue;

use PhpAmqpLib\Message\AMQPMessage;

interface ConsumerInterface
{
    /**
     * @throws \Exception
     */
    public function consume(AMQPMessage $message): MessageProcessFlag;

    public function getQueueName(): string;

    public function getExchangeName(): string;
}
