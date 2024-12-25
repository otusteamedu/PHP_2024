<?php

namespace PaymentServiceBundle\Controller\Amqp\Payment\Delete;

class Message
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $parentUuid,
    ) {
    }
}
