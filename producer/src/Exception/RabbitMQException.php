<?php

namespace Producer\Exception;

class RabbitMQException extends ApplicationException
{
    public function __construct(string $message)
    {
        parent::__construct("RabbitMQ: {$message}");
    }
}
