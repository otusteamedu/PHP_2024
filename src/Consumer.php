<?php

declare(strict_types=1);

namespace App;

class Consumer extends RabbitMQAbstract
{
    public function consume(string $queueName, callable $callback): void
    {
        $this->getChannel()->basic_consume($queueName, '', false, true, false, false, $callback);

        while ($this->getChannel()->is_consuming()) {
            $this->getChannel()->wait();
        }
    }
}
