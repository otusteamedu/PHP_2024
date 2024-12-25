<?php

namespace PaymentServiceBundle\Domain\DTO\Bus;

class PaymentDeleteDTO
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $parentUuid,
    ) {
    }
}
