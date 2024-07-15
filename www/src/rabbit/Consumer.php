<?php

namespace Ahor\Hw19\rabbit;

class Consumer extends RabbitMQ
{
    public function consume(string $queueName, callable $callback): void
    {
        $this->declare($queueName);

        $this->getChannel()->basic_consume($queueName, '', false, true, false, false, $callback);

        while ($this->getChannel()->is_consuming()) {
            $this->getChannel()->wait();
        }
    }
}
