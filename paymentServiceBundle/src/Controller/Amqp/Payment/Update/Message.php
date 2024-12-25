<?php

namespace PaymentServiceBundle\Controller\Amqp\Payment\Update;

class Message
{
    public function __construct(
        public readonly string  $uuid,
        public readonly string  $parentUuid,
        public readonly ?int    $amount,
        public readonly ?string $purpose,
    ) {
    }
}
