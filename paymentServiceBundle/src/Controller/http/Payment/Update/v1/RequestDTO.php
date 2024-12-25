<?php

namespace PaymentServiceBundle\Controller\http\Payment\Update\v1;

class RequestDTO
{
    public function __construct(
        public readonly ?int    $amount,
        public readonly ?string $purpose
    ) {
    }
}
