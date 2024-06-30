<?php

namespace Producer\Exception;

class RabbitMQSendException extends RabbitMQException
{
    public function __construct(string $message)
    {
        parent::__construct("Failed to send message: {$message}");
    }
}
