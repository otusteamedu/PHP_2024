<?php

namespace PaymentServiceBundle\Controller\http\Payment\Get\v1;

class OutputPaymentDTO
{
    public function __construct(
        public readonly string  $uuid,
        public readonly string  $status,
        public readonly int     $userId,
        public readonly string  $type,
        public readonly ?int    $amount,
        public readonly ?string $purpose,
        public readonly string  $dateTime
    ) {
    }
}
