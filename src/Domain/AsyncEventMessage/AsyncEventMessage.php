<?php

namespace AKornienko\Php2024\Domain\AsyncEventMessage;

use AKornienko\Php2024\Domain\UserDataRequest\UserDataRequest;
use PhpAmqpLib\Message\AMQPMessage;

class AsyncEventMessage
{
    private $msg;

    public function __construct(UserDataRequest $request)
    {
        $requestValue = $request->getValue();
        $this->msg = new AMQPMessage(' name = ' . $requestValue['name'] . ' ' . ' email = ' . $requestValue['email']);
    }

    public function getValue(): AMQPMessage
    {
        return $this->msg;
    }
}
