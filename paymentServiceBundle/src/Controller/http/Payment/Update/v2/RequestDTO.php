<?php

namespace PaymentServiceBundle\Controller\http\Payment\Update\v2;

class RequestDTO
{
    public function __construct(
        public readonly ?int    $amount,
        public readonly ?string $purpose
    ) {
    }
}
