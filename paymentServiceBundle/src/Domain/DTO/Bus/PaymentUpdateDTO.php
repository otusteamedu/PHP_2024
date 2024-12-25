<?php

namespace PaymentServiceBundle\Domain\DTO\Bus;

class PaymentUpdateDTO
{
    public function __construct(
        public readonly string  $uuid,
        public readonly string  $parentUuid,
        public readonly ?int    $amount,
        public readonly ?string $purpose,
    ) {
    }
}
