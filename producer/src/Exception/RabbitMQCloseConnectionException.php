<?php

namespace Producer\Exception;

class RabbitMQCloseConnectionException extends RabbitMQException
{
    public function __construct(string $message)
    {
        parent::__construct("Failed to close connection: {$message}");
    }
}
