<?php

namespace PaymentServiceBundle\Domain\DTO\Bus;

class PaymentCreateDTO
{
    public function __construct(
        public readonly string  $uuid,
        public readonly int     $userId,
        public readonly int     $amount,
        public readonly string  $purpose
    ) {
    }
}

