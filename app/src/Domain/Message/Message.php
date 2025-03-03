<?php

namespace AnatolyShilyaev\App\Domain\Message;

use AnatolyShilyaev\App\Domain\Request\Request;
use PhpAmqpLib\Message\AMQPMessage;

class Message
{
    private $msg;

    public function __construct(Request $request)
    {
        $requestValue = $request->getValue();
        $this->msg = new AMQPMessage(' dateFrom = ' . $requestValue['dateFrom'] . ' ' . ' dateTo = ' . $requestValue['dateTo']);
    }

    public function getValue(): AMQPMessage
    {
        return $this->msg;
    }
}
