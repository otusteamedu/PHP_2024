<?php

namespace PaymentServiceBundle\Controller\Amqp\Payment\Create;

class Message
{
    public function __construct(
        public readonly string  $uuid,
        public readonly int     $userId,
        public readonly int     $amount,
        public readonly string  $purpose,
    ) {
    }
}
