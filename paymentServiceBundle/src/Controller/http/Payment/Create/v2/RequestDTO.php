<?php

namespace PaymentServiceBundle\Controller\http\Payment\Create\v2;

class RequestDTO
{
    public function __construct(
        public readonly int     $userId,
        public readonly int     $amount,
        public readonly string  $purpose
    ) {
    }
}
